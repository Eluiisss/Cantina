<?php

namespace Tests\Feature\Admin\OrdersTest;

use Admin\OrdersTest\BaseOrdersTest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowOrderTest extends TestCase
{
    use RefreshDatabase, BaseOrdersTest;

    /** @test */
    public function it_displays_a_404_error_if_the_order_is_not_found()
    {
        $this->withExceptionHandling();
        $this->get(route('orders.show', ['order' => 999]))
            ->assertStatus(404);
    }

    /** @test */
    public function it_loads_the_orders_details_page()
    {

        $this->createUserRole();
        $user = $this->createUser("Pepe Garcia", "pepe@gmail.com");

        $category = Category::factory()->create([
            'name' => 'Snacks'
        ]);
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
            'price' => 2.00,
            'discounted_price' => 1.00,
            'discount' => 50,
        ]);

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'order_code' => 'e321',
            'order_status' => 'no_recogido',
            'payment_status' => 'sin_pagar',
            'created_at' => '2021-09-30 14:20:00'
        ]);
        $order->articles()
            ->attach([$article_1->id, $article_2->id], [
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        $this->get(route('orders.show', ['order' => $order->id]))
            ->assertOk()
            ->assertSeeInOrder([
                'E321',
                'No recogido',
                'Sin pagar',
                '2021-09-30 14:20:00',
                'Pizza',
                'Snacks',
                '1.75',
                'Empanada',
                'Snacks',
                '1.00',
                '2.75',
                'Pepe Garcia',
                '2ºDAM',
                'pepe@gmail.com',
                '656238544',
            ]);
    }
}
