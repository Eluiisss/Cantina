<?php

namespace Tests\Feature\Admin\OrdersTest;

use Admin\OrdersTest\BaseOrdersTest;
use App\Models\Article;
use App\Models\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListOrdersTest extends TestCase
{
    use RefreshDatabase, BaseOrdersTest;


    /** @test  */
    public function it_shows_the_orders_list(){

        $this->createUserRole();
        $userFirst = $this->createUser();
        $userSecond = $this->createUser();

        $this->createArticles();
        $articles = Article::inRandomOrder()->take(rand(1,2))->pluck('id');

        $oldOrder = Order::factory()->create([
            'user_id' => $userFirst->id,
            'order_code' => 'Z150',
            'created_at' => '2021-09-30 23:59:59'
        ]);
        $oldOrder->articles()
        ->attach($articles, [
            'quantity' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $middleOrder = Order::factory()->create([
            'user_id' => $userSecond->id,
            'order_code' => 'H300',
            'created_at' => '2021-10-05 00:00:00',
        ]);
        $middleOrder->articles()
            ->attach($articles, [
                'quantity' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        $newOrder = Order::factory()->create([
            'user_id' => $userSecond->id,
            'order_code' => 'A200',
            'created_at' => '2021-10-10 00:00:00',
        ]);
        $newOrder->articles()
            ->attach($articles, [
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
        ]);

        $response = $this->actingAs($this->getAdmin())->get(route('orders.index'));
        $response->assertStatus(200);
        $response->assertSee(trans('orders.title.index'));

        $response->assertSeeInOrder([
            'Z150',
            'H300',
            'A200',
        ]);
    }

    /** @test  */
    public function shows_a_default_message_if_order_list_is_empty()
    {
        $this->assertDatabaseEmpty('orders');
        $this->assertDatabaseEmpty('article_order');
        $response = $this->actingAs($this->getAdmin())->get(route('orders.index'))->assertStatus(200);
        $response->assertSee('Sin datos');
    }

    /** @test  */
    public function it_paginate_the_orders()
    {
        $this->createUserRole();
        $user = $this->createUser();

        Order::factory()->create([
            'user_id' => $user->id,
            'order_code' => 'B234',
            'created_at' => '2020-12-30 00:00:00'
        ]);

        Order::factory()->create([
            'user_id' => $user->id,
            'order_code' => 'A123',
            'created_at' => '2020-09-30 23:59:59'
        ]);

        Order::factory()->times(15)->create([
            'user_id' => $user->id,
        ]);

        Order::factory()->create([
            'user_id' => $user->id,
            'order_code' => 'Z987',
            'created_at' => '2021-12-01 00:00:00'
        ]);

        $response = $this->actingAs($this->getAdmin())->get(route('orders.index', ['page'=>'1']))->assertStatus(200);
        $response->assertSeeInOrder(['A123', 'B234']);
        $response->assertDontSee('Z987');

        $response = $this->actingAs($this->getAdmin())->get(route('orders.index', ['page'=>'2']))->assertStatus(200);
        $response->assertSee('Z987');
        $response->assertDontSee('A123');
        $response->assertDontSee('B234');

    }
}
