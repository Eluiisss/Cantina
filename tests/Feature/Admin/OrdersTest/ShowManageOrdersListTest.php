<?php

namespace Tests\Feature\Admin\OrdersTest;

use App\Http\Livewire\OrderManageSideBar;
use App\Models\Article;
use App\Models\Category;
use App\Models\Nre;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Livewire;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowManageOrdersListTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    /** @test  */
    public function show_the_orders_in_the_side_bar()
    {
        $this->createUserRole();
        $this->createArticles();

        $userPepe = $this->createUser('Pepe López');

        $articles = Article::inRandomOrder()->take(2)->pluck('id');

        $order = Order::factory()->readyToCollect()->notPayedYet()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'a100',
            'created_at' => now()->subMinutes(35)
        ]);
        $order->articles()
            ->attach($articles, [
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);


        $userJuan = $this->createUser('Juan López');

        $articles = Article::inRandomOrder()->take(1)->pluck('id');

        $order = Order::factory()->collected()->alreadyPayed()->create([
            'user_id' => $userJuan->id,
            'order_code' => 'b340',
            'created_at' => now()
        ]);
        $order->articles()
            ->attach($articles, [
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        $response = $this->get(route('orders.manage'));
        $response->assertStatus(200)
            ->assertSeeLivewire('order-manage-side-bar')
            ->assertSeeLivewire('order-manage-detail-view');
        $response->assertSeeInOrder([
            'border-red-600',
            'PEDIDO: A100',
            'text-red-300',
            'Pepe López',
            '(2 Articulos)',
            '35 minutes ago',
            'border-gray-200',
            'PEDIDO: B340 (RECOGIDO)',
            'green-600',
            'Juan López',
            '(1 Articulos)',
            '1 second ago',
        ]);
    }

    /** @test  */
    public function it_shows_a_default_message_when_are_no_orders()
    {
        $response = $this->get(route('orders.manage'));
        $response->assertStatus(200)
            ->assertSee('Sin pedidos');
    }

    /** @test  */
    public function show_the_order_detail_in_the_details_view()
    {
        $this->createUserRole();
        $this->createArticles();

        $userPepe = $this->createUser('Pepe López', 'pepe@mail.com');

        $category = Category::factory()->create(['name' => 'Snacks']);
        $articles = Article::factory()->create([
            'category_id' => $category->id,
            'name' => "Pizza",
            'price' => 1.75,
            'discounted_price' => 1.75,
            'discount' => 0,
        ]);

        $order = Order::factory()->readyToCollect()->notPayedYet()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'r232',
            'created_at' => '2021-09-30 14:20:00',
        ]);
        $order->articles()
            ->attach($articles, [
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        Livewire::test('order-manage-detail-view')->emit('orderSelected', $order->id)
            ->assertSeeInOrder([
                'Pepe López',
                'pepe@mail.com',
                '¡RECOGIDO!',
                'REPORTAR',
                'Código pedido: R232',
                'Pendiente',
                'Sin pagar',
                '2021-09-30 14:20:00',
                'Pizza',
                'Snacks',
                '1.75',
                'Pepe López',
                '2ºDAM',
                'pepe@mail.com',
                '656238544',
            ]);
    }

    /** @test  */
    public function it_change_the_details_when_order_are_focused()
    {
        $this->createUserRole();
        $this->createArticles();

        $userPepe = $this->createUser('Pepe López', 'pepe@mail.com');

        $category = Category::factory()->create(['name' => 'Snacks']);
        $articles = Article::factory()->create([
            'category_id' => $category->id,
            'name' => "Pizza",
            'price' => 1.75,
            'discounted_price' => 1.75,
            'discount' => 0,
        ]);

        $firstOrder = Order::factory()->readyToCollect()->notPayedYet()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'r232',
            'created_at' => '2021-09-30 14:20:00',
        ]);
        $firstOrder->articles()
            ->attach($articles, [
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        $userJuan = $this->createUser('Juan López', 'juan@mail.com');

        $secondOrder = Order::factory()->collected()->alreadyPayed()->create([
            'user_id' => $userJuan->id,
            'order_code' => 'b445',
            'created_at' => '2021-10-12 13:20:00',
        ]);
        $secondOrder->articles()
            ->attach($articles, [
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        Livewire::test('order-manage-detail-view')->emit('orderSelected', $firstOrder->id)
            ->assertSeeInOrder([
                'Pepe López',
                'pepe@mail.com',
                '¡RECOGIDO!',
                'REPORTAR',
                'Código pedido: R232',
                'Pendiente',
                'Sin pagar',
                '2021-09-30 14:20:00',
            ])->assertDontSee([
                'Juan López',
                'juan@mail.com',
                'Código pedido: B445',
                'Recogido',
                'Pagado',
                '2021-10-12 13:20:00',
            ])->assertSeeHtml('<span class="mr-2">¡RECOGIDO!</span>')
             ->assertSeeHtml('<span class="mr-2">REPORTAR</span>')
            ->assertDontSeeHtml('<p class="font-semibold text-xl text-green-400"> RECOGIDO</p>');

        Livewire::test('order-manage-detail-view')->emit('orderSelected', $secondOrder->id)
            ->assertSeeInOrder([
                'Juan López',
                'juan@mail.com',
                'Código pedido: B445',
                'Recogido',
                'Pagado',
                '2021-10-12 13:20:00',
            ])->assertDontSee([
                'Pepe López',
                'pepe@mail.com',
                '¡RECOGIDO!',
                'REPORTAR',
                'Código pedido: R232',
                'Pendiente',
                'Sin pagar',
                '2021-09-30 14:20:00',
            ])->assertDontSeeHtml('<span class="mr-2">¡RECOGIDO!</span>')
            ->assertDontSeeHtml('<span class="mr-2">REPORTAR</span>')
            ->assertSeeHtml('<p class="font-semibold text-xl text-green-400"> RECOGIDO</p>');
    }

    /** @test  */
    public function it_loads_more_orders_when_scroll_down_event_is_fired()
    {
        $this->createUserRole();
        $this->createArticles();

        $userPepe = $this->createUser('Pepe López');

        foreach (range(0,19) as $i){

            $articles = Article::inRandomOrder()->take(2)->pluck('id');

            $order = Order::factory()->readyToCollect()->notPayedYet()->create([
                'user_id' => $userPepe->id,
                'created_at' => now()->subMinutes(rand(0,10))
            ]);
            $order->articles()
                ->attach($articles, [
                    'quantity' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

        }

        $newerOrder = Order::first();
        $newerOrder->update(['order_code' => 'a123',
            'created_at' => now()]);

        $this->assertDatabaseCount('orders', 20);

        Livewire::test(OrderManageSideBar::class)->assertViewHas('orders', function ($orders) use($newerOrder) {
           return $orders->count() == 10;
         })->assertDontSee('A123');

        Livewire::test(OrderManageSideBar::class)->call('loadMore')->assertViewHas('orders', function ($orders)  {
            return $orders->count() == 20;
        })->assertSee('A123');
    }

    private function createUser($name, $email = null)
    {
        $nre = Nre::factory()->create();
        $user = User::factory()->create([
            'name' => $name,
            'nre_id' => $nre->id,
            'class' => '2ºDAM',
            'email' => $email ?? (Str::snake($name).'@mail.com'),
            'phone' => '656238544',

        ]);
        $user->attachRole($this->role);
        return $user;
    }

    private function createArticles(): void
    {
        $category = Category::factory()->create();
        Article::factory()->times(20)->create([
            'category_id' => $category->id
        ]);
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
