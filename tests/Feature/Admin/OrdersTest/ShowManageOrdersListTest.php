<?php

namespace Tests\Feature\Admin\OrdersTest;

use Admin\OrdersTest\BaseOrdersTest;
use App\Http\Livewire\OrderManageSideBar;
use App\Models\Article;
use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use Livewire\Livewire;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowManageOrdersListTest extends TestCase
{
    use RefreshDatabase, BaseOrdersTest;

    protected $role;

    /** @test  */
    public function show_the_orders_in_the_side_bar()
    {
        $this->actingAs($this->getAdmin());
        $this->createUserRole();
        $this->createArticles();

        $userPepe = $this->createUser('Pepe López');

        $articles = Article::inRandomOrder()->take(2)->pluck('id');

        Carbon::setTestNow(Carbon::create(2021, 12, 17, 14));

        $order = Order::factory()->readyToCollect()->notPayedYet()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'A10000000',
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
            'order_code' => 'B34000000',
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
            'red',
            'Pepe López',
            '(2 Articulos)',
            'hace 35 minutos',
            'PEDIDO: B340 (RECOGIDO)',
            'green',
            'Juan López',
            '(1 Articulos)',
            'hace 1 segundo',
        ]);
    }

    /** @test  */
    public function it_shows_a_default_message_when_are_no_orders()
    {

        $response = $this->actingAs($this->getAdmin())->get(route('orders.manage'));
        $response->assertStatus(200)
            ->assertSee('Sin pedidos');
    }

    /** @test  */
    public function show_the_order_detail_in_the_details_view()
    {
        $this->actingAs($this->getAdmin());
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

        $created_at = Carbon::today();
        $order = Order::factory()->readyToCollect()->notPayedYet()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'R23200000',
            'client_note' => 'Buenas tardes, me gustaria si es posible  que la pizza no tenga pelos si? GRACIAS!!',
            'created_at' => $created_at,
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
                $created_at->toDayDateTimeString(),
                'Buenas tardes, me gustaria si es posible  que la pizza no tenga pelos si? GRACIAS!!',
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
        $this->actingAs($this->getAdmin());
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
        $firstOrderDate = Carbon::today();

        $firstOrder = Order::factory()->readyToCollect()->notPayedYet()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'R23200000',
            'created_at' => $firstOrderDate,
        ]);
        $firstOrder->articles()
            ->attach($articles, [
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        $userJuan = $this->createUser('Juan López', 'juan@mail.com');

        $secondOrderDate = Carbon::yesterday();
        $secondOrder = Order::factory()->collected()->alreadyPayed()->create([
            'user_id' => $userJuan->id,
            'order_code' => 'B44500000',
            'created_at' => $secondOrderDate,
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
                $firstOrderDate->toDayDateTimeString(),
            ])->assertDontSee([
                'Juan López',
                'juan@mail.com',
                'Código pedido: B445',
                'Recogido',
                'Pagado',
                $secondOrderDate->toDateTimeString()
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
                $secondOrderDate->toDayDateTimeString(),
            ])->assertDontSee([
                'Pepe López',
                'pepe@mail.com',
                '¡RECOGIDO!',
                'REPORTAR',
                'Código pedido: R232',
                'Pendiente',
                'Sin pagar',
                $firstOrderDate->toDayDateTimeString(),
            ])->assertDontSeeHtml('<span class="mr-2">¡RECOGIDO!</span>')
            ->assertDontSeeHtml('<span class="mr-2">REPORTAR</span>')
            ->assertSeeHtml('<p class="font-semibold text-xl text-green-400"> RECOGIDO</p>');
    }

    /** @test  */
    public function it_loads_more_orders_when_scroll_down_event_is_fired()
    {
        $this->actingAs($this->getAdmin());
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
        $newerOrder->update(['order_code' => 'A12300000',
            'created_at' => now()]);

        $this->assertDatabaseCount('orders', 20);

        Livewire::test(OrderManageSideBar::class)->assertViewHas('orders', function ($orders) use($newerOrder) {
           return $orders->count() == 10;
         })->assertDontSee('A123');

        Livewire::test(OrderManageSideBar::class)->call('loadMore')->assertViewHas('orders', function ($orders)  {
            return $orders->count() == 20;
        })->assertSee('A123');
    }
}
