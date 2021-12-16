<?php

namespace Tests\Feature\Admin\OrdersTest;

use Admin\OrdersTest\BaseOrdersTest;
use App\Models\Order;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageOrdersTest extends TestCase
{
    use RefreshDatabase, BaseOrdersTest;

    /** @test  */
    public function the_client_collect_his_order()
    {
        $this->actingAs($this->getAdmin());
        $this->createUserRole();
        $this->createArticles();

        $userPepe = $this->createUser('Pepe López', 'pepe@mail.com');

        $order = Order::factory()->readyToCollect()->notPayedYet()->create([
            'id' => '1',
            'user_id' => $userPepe->id,
            'order_code' => 'R23200000',
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
            ])->call('setOrderAsCollected', '1')
            ->assertSeeInOrder([
                'Pepe López',
                'pepe@mail.com',
                'RECOGIDO',
                'Código pedido: R232',
                'Recogido',
                'Pagado',
            ]);

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', [
            'order_status' => 'recogido',
            'payment_status' => 'ya_pagado'
        ]);
    }

    /** @test  */
    public function the_client_dont_collect_his_order_and_get_reported()
    {
        $this->actingAs($this->getAdmin());
        $this->createUserRole();
        $this->createArticles();

        $userPepe = $this->createUser('Pepe López', 'pepe@mail.com');

        $order = Order::factory()->readyToCollect()->notPayedYet()->create([
            'id' => '1',
            'user_id' => $userPepe->id,
            'order_code' => 'R23200000',
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
            ])->call('setOrderAsNotCollected', '1')
            ->assertSeeInOrder([
                'Pepe López',
                'pepe@mail.com',
                'NO RECOGIDO',
                'Código pedido: R232',
                'No recogido',
                'Sin pagar',
            ]);

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', [
            'order_status' => 'no_recogido',
            'payment_status' => 'sin_pagar'
        ]);
    }

    /** @test  */
    public function the_client_get_banned_after_three_non_collected_orders(){
        $this->actingAs($this->getAdmin());
        $this->createUserRole();
        $this->createArticles();

        $userPepe = $this->createUser('Pepe López', 'pepe@mail.com');

        foreach (range(1,3) as $i){

            $order = Order::factory()->readyToCollect()->notPayedYet()->create([
                'id' => $i,
                'user_id' => $userPepe->id,
            ]);

            Livewire::test('order-manage-detail-view')
                ->emit('orderSelected', $order->id)
                ->call('setOrderAsNotCollected', $order->id);

            $this->assertDatabaseHas('orders', [
                'id' => $order->id,
                'order_status' => 'no_recogido',
                'payment_status' => 'sin_pagar'
            ]);

                if($i == 3){
                    $this->assertDatabaseHas('users', [
                        'id' => $userPepe->id,
                        'banned' => 1,
                        'ban_strikes' => 0,
                    ]);
                }else {
                    $this->assertDatabaseHas('users', [
                        'id' => $userPepe->id,
                        'banned' => 0,
                        'ban_strikes' => $i,
                    ]);
                }
        }
    }
}
