<?php

namespace Tests\Feature\Admin\OrdersTest;

use Admin\OrdersTest\BaseOrdersTest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowOrderHistoryTest extends TestCase
{
    use RefreshDatabase, BaseOrdersTest;

    /** @test */
    public function it_show_the_orders_of_the_user()
    {
        $this->createUserRole();
        $user = $this->createUser();
        $this->actingAs($user);

        $category = Category::factory()->create();

        $article_1 = Article::factory()->create([
            'category_id' => $category->id,
            'name' => "Pizza",
            'price' => 1.75,
            'discounted_price' => 1.75,
            'discount' => 0,
        ]);

        $article_2 = Article::factory()->create([
            'category_id' => $category->id,
            'name' => "Empanada",
            'price' => 2.70,
            'discounted_price' => 2.70,
            'discount' => 0,
        ]);

        $created_at = Carbon::today();

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'order_code' => 'E32100000',
            'order_status' => 'pendiente',
            'payment_status' => 'sin_pagar',
            'created_at' => $created_at
        ]);
        $order->articles()
            ->attach([$article_1->id, $article_2->id], [
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        Livewire::test('order-user-history')->assertSee(trans('orders.userHistory.title'))
            ->assertSee([
                'PEDIDO: E321',
                'Total del pedido: (2 Articulos)',
                'Productos:
                    Pizza x 1 (1.75 €)
                          ,
                                            Empanada x 1 (2.70 €)
                                     ',
                'Sin pagar',
                'Importe total: €4.45',
        ]);

    }

    /** @test */
    public function it_show_a_non_history_message_where_user_has_no_orders()
    {
        $this->createUserRole();
        $user = $this->createUser();
        $this->actingAs($user);

        Livewire::test('order-user-history')->assertSeeInOrder([
            'No tienes pedidos realizados',
            'Tu historial de pedidos se mostrara aqui cuando realices una compra en la cantina'
        ]);
    }

    /** @test */
    public function it_opens_a_modal_with_the_order_description()
    {
        $this->createUserRole();
        $user = $this->createUser();
        $this->actingAs($user);

        $category = Category::factory()->create();

        $article_1 = Article::factory()->create([
            'category_id' => $category->id,
            'name' => "Pizza",
            'price' => 1.75,
            'discounted_price' => 1.75,
            'discount' => 0,
        ]);

        $article_2 = Article::factory()->create([
            'category_id' => $category->id,
            'name' => "Empanada",
            'price' => 2.70,
            'discounted_price' => 2.70,
            'discount' => 0,
        ]);

        $created_at = Carbon::today();

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'order_code' => 'E32100000',
            'order_status' => 'pendiente',
            'payment_status' => 'sin_pagar',
            'created_at' => $created_at
        ]);
        $order->articles()
            ->attach([$article_1->id, $article_2->id], [
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        Livewire::test('order-user-history')
            ->call('openOrderModal', $order->id)
            ->assertSeeInOrder([
                'Código pedido: E321',
                'Pendiente',
                'Sin pagar',
                $created_at->toDayDateTimeString(),
                'Pizza',
                '1.75',
                'Empanada',
                '2.70',
                '4.45',
            ])->call('closeOrderModal')
            ->assertDontSee([
                'Código pedido: E321',
                $created_at->toDayDateTimeString(),
            ]);
    }
}
