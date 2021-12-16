<?php

namespace Tests\Feature\Admin\CartTest;
use App\Http\Livewire\CartComp;
use App\Models\Article;
use App\Models\Category;
use App\Models\Nre;
use App\Models\Role;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Session;

class ShowCartTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    /** @test */
    public function the_user_can_add_a_product_to_cart()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $article = Article::factory()->create(['name' => 'Pizza', 'discounted_price' => 1.70, 'category_id' => $category->id]);

        $this->post(route('cart.store'), [
                'article_id' => $article->id,
            ])->assertRedirect(route('shop.index'))
            ->assertSessionHas('cart');

        Livewire::test(CartComp::class)->assertSee([
            'Tu Carrito',
            'Artículo',
            'Cantidad',
            'Precio(Unidad)',
            'Precio Total',
            'Usar Crédito ( 50.00 € )'
        ])->assertSeeInOrder(
            [
            'Pizza',
            '1',
            '1.70 €',
            '1.70 €'
            ]);
    }

    /** @test */
    public function the_user_is_redirected_to_the_shop_if_cart_is_empty(){

        $user = $this->createUser();
        $this->actingAs($user);

        $this->get(route('cart.store'))
            ->assertRedirect(route('shop.index'))
            ->assertSessionMissing('cart');
    }

    /** @test */
    public function the_user_can_increment_or_decrement_an_article_of_cart(){

        $user = $this->createUser();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $article = Article::factory()->create(['name' => 'Pizza', 'discounted_price' => 2.50, 'category_id' => $category->id]);

        Cart::add($article->id, $article->name, 1, $article->discounted_price);
        Session::put([$article->name.''.$article->id => $article->image]);

        $cart = Cart::content();

        Livewire::test(CartComp::class)
            ->call('moreQty',$cart->first()->rowId)
            ->assertSeeInOrder(
            [
                'Pizza',
                '2',
                '2.50 €',
                '5.00 €',
                '5.00 €'
            ]);

        Livewire::test(CartComp::class)
            ->call('lessQty',$cart->first()->rowId)
            ->assertSeeInOrder(
            [
                'Pizza',
                '1',
                '2.50 €',
                '2.50 €',
                '2.50 €'
            ]);
    }

    /** @test */
    public function the_user_can_quit_an_article_of_cart(){

        $user = $this->createUser();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $article = Article::factory()->create(['name' => 'Pizza', 'discounted_price' => 2.50, 'category_id' => $category->id]);

        Cart::add($article->id, $article->name, 1, $article->discounted_price);
        Session::put([$article->name.''.$article->id => $article->image]);

        $cart = Cart::content();

        Livewire::test(CartComp::class)
            ->assertSee('Pizza')
            ->call('delete',$cart->first()->rowId)
            ->assertDontSee('Pizza');

    }

    /** @test */
    public function the_user_can_not_use_credit_if_doesnt_have_enough(){

        $user = $this->createUser();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $article = Article::factory()->create(['name' => 'Pizza', 'discounted_price' => 10.00, 'category_id' => $category->id]);

        Cart::add($article->id, $article->name, 5, $article->discounted_price);
        Session::put([$article->name.''.$article->id => $article->image]);

        $cart = Cart::content();

        Livewire::test(CartComp::class)
            ->assertSee('Usar Crédito ( 50.00 € )')
            ->assertDontSee('Crédito insuficiente( 50.00 € )')
            ->call('moreQty',$cart->first()->rowId)
            ->assertDontSee('Usar Crédito ( 50.00 € )')
            ->assertSee('Crédito insuficiente( 50.00 € )');

    }

    /** @test */
    public function not_payed_cart_create_a_new_order(){

        $user = $this->createUser();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $article = Article::factory()->create(['name' => 'Agua', 'discounted_price' => 2.00, 'category_id' => $category->id]);

        Cart::add($article->id, $article->name, 3, $article->discounted_price);
        Session::put([$article->name.''.$article->id => $article->image]);

        Livewire::test(CartComp::class)->set('client_note', 'Descripción del pedido')
            ->call('setClientNote');

        $this->get(route('orders.newOrder'))
            ->assertRedirect(route('shop.index'))
            ->assertSessionHas('cart', []);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'created_at' => now(),
            'order_status' => 'pendiente',
            'payment_status' => 'sin_pagar',
            'total_payed' => NULL,
            'client_note' => 'Descripción del pedido'
        ]);

        $this->assertDatabaseHas('article_order', [
            'article_id' => $article->id,
            'quantity' => '3'
        ]);
    }

    /** @test */
    public function a_payed_cart_create_a_new_payed_order(){

        $user = $this->createUser();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $article = Article::factory()->create(['name' => 'Agua', 'discounted_price' => 2.00, 'category_id' => $category->id]);

        Cart::add($article->id, $article->name, 3, $article->discounted_price);
        Session::put([$article->name.''.$article->id => $article->image]);

        Livewire::test(CartComp::class)->set('client_note', 'Descripción del pedido')
            ->call('setClientNote');

        $this->get(route('orders.newPayedOrder'))
            ->assertRedirect(route('shop.index'))
            ->assertSessionHas('cart', []);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'created_at' => now(),
            'order_status' => 'pendiente',
            'payment_status' => 'ya_pagado',
            'total_payed' => 6.00,
            'client_note' => 'Descripción del pedido'
        ]);

        $this->assertDatabaseHas('article_order', [
            'article_id' => $article->id,
            'quantity' => '3'
        ]);
    }

    /** @test */
    public function the_cart_of_banned_users_can_not_be_purchased(){

        $user = $this->createUser(NULL,NULL,1);
        $this->actingAs($user);

        $category = Category::factory()->create();
        $article = Article::factory()->create(['name' => 'Agua', 'discounted_price' => 2.00, 'category_id' => $category->id]);

        Cart::add($article->id, $article->name, 3, $article->discounted_price);
        Session::put([$article->name.''.$article->id => $article->image]);

        $this->get(route('orders.newOrder'))
            ->assertRedirect(route('shop.index'))
            ->assertSessionHas('cart');

        $this->assertDatabaseEmpty('orders');
        $this->assertDatabaseEmpty('article_order');
    }

    /** @test */
    public function cart_client_note_has_max_scope_of_1000_characters(){
        $user = $this->createUser();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $article = Article::factory()->create(['name' => 'Agua', 'discounted_price' => 2.00, 'category_id' => $category->id]);

        Cart::add($article->id, $article->name, 3, $article->discounted_price);
        Session::put([$article->name.''.$article->id => $article->image]);

        $maxNote = Str::random(1000);
        $overScopeNote = $maxNote . 'Texto de mas';

        Livewire::test(CartComp::class)->set('client_note', $overScopeNote)
            ->call('setClientNote');

        $this->get(route('orders.newOrder'))
            ->assertRedirect(route('shop.index'))
            ->assertSessionHas('cart');

        $this->assertDatabaseHas('orders', [
            'client_note' => $maxNote
        ]);

        $this->assertDatabaseMissing('orders', [
            'client_note' => $overScopeNote
        ]);

    }

    private function createUser($name = null, $email = null, $ban = 0)
    {
        $nre = Nre::factory()->create();
        $user = User::factory()->create([
            'nre_id' => $nre->id,
            'class' => '2ºDAM',
            'phone' => '656238544',
            'credit' => 50.00,
            'banned' => $ban,
            'ban_strikes' => 0,
        ]);

        if ($name){
            $user->update([
                'name' => $name,
                'email' => $email ?? (Str::snake($name).'@mail.com'),
            ]);
        }

        $user->attachRole($this->role);
        return $user;
    }

    private function createUserRole(): void
    {
        $this->role = Role::create([
            'name' => 'user',
            'display_name' => 'User ',
            'description' => 'User is not allowed to manage and edit other users',
        ]);
    }

}
