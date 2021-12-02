<?php

namespace Tests\Feature\Admin\OrdersTest;

use Admin\OrdersTest\BaseOrdersTest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrdersTriggersTest extends TestCase
{
    use RefreshDatabase, BaseOrdersTest;

    /** @test  */
    public function it_update_the_stock_of_articles_when_orders_is_created(){

        $this->createUserRole();
        $user = $this->createUser();
        $category = Category::factory()->create();

        $pizza = Article::factory()->create([
            'category_id' => $category->id,
            'name' => "Pizza",
            'stock' => 10,
            'created_at' => now()
        ]);

       $agua = Article::factory()->create([
            'category_id' => $category->id,
            'name' => "Botella de agua",
            'stock' => 50,
            'created_at' => now()
        ]);

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'order_status' => 'pendiente',
            'created_at' => '2021-09-30 23:59:59'
        ]);
        $order->articles()
            ->attach($pizza, [
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        $order->articles()
            ->attach($agua, [
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        $this->assertDatabaseHas('articles', [
            'name' => 'Pizza',
            'stock' => 8,
            'name' => 'Botella de agua',
            'stock' => 49,
        ]);
    }

    /** @test  */
    public function it_restore_the_stock_of_articles_when_an_order_is_not_collected(){

        $this->createUserRole();
        $user = $this->createUser();
        $category = Category::factory()->create();

        $pizza = Article::factory()->create([
            'category_id' => $category->id,
            'name' => "Pizza",
            'stock' => 10,
            'created_at' => now()
        ]);

        $agua = Article::factory()->create([
            'category_id' => $category->id,
            'name' => "Botella de agua",
            'stock' => 50,
            'created_at' => now()
        ]);

        $order = Order::factory()->create([
            'user_id' => $user->id,
            'order_status' => 'pendiente',
            'created_at' => '2021-09-30 23:59:59'
        ]);
        $order->articles()
            ->attach($pizza, [
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        $order->articles()
            ->attach($agua, [
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        $order->update(['order_status' => 'no_recogido',]);

        $this->assertDatabaseHas('articles', [
            'name' => 'Pizza',
            'stock' => 10,
            'name' => 'Botella de agua',
            'stock' => 50,
        ]);
    }

}
