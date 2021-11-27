<?php

namespace Tests\Feature\Admin\OrdersTest;

use Admin\OrdersTest\BaseOrdersTest;
use App\Models\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterOrdersTest extends TestCase
{
    use RefreshDatabase, BaseOrdersTest;

    /** @test */
    public function it_loads_the_orders_list_page_with_filters()
    {
        $this->actingAs($this->getAdmin())->get(route('orders.index'))
            ->assertStatus(200)
            ->assertSee(trans('orders.manage.filters.order'))
            ->assertSee(trans('orders.manage.filters.payment'));
    }


    /** @test */
    public function it_filters_the_order_status()
    {
        $this->actingAs($this->getAdmin());

        $userPepe = $this->createUser('Pepe López');

        $collected = Order::factory()->collected()->create(['user_id' => $userPepe->id,]);
        $readyToCollect = Order::factory()->readyToCollect()->create(['user_id' => $userPepe->id,]);
        $notCollected = Order::factory()->notCollected()->create(['user_id' => $userPepe->id,]);

        $this->get('orders?orderStatus=recogido')->assertViewHas('orders', function ($orders) use ($collected, $readyToCollect, $notCollected){
            return  (true == $orders->contains($collected))
                && (false == $orders->contains($readyToCollect))
                && (false == $orders->contains($notCollected));
        });

        $this->get('orders?orderStatus=pendiente')->assertViewHas('orders', function ($orders) use ($collected, $readyToCollect, $notCollected){
            return  (true == $orders->contains($readyToCollect))
                && (false == $orders->contains($collected))
                && (false == $orders->contains($notCollected));
        });

        $this->get('orders?orderStatus=no_recogido')->assertViewHas('orders', function ($orders) use ($collected, $readyToCollect, $notCollected){
            return  (true == $orders->contains($notCollected))
                && (false == $orders->contains($readyToCollect))
                && (false == $orders->contains($collected));
        });
    }

    /** @test */
    public function it_filters_the_order_payment()
    {
        $this->actingAs($this->getAdmin());

        $userPepe = $this->createUser('Pepe López');

        $payed = Order::factory()->alreadyPayed()->create(['user_id' => $userPepe->id,]);
        $notPayed = Order::factory()->notPayedYet()->create(['user_id' => $userPepe->id,]);

        $this->get('orders?paymentStatus=ya_pagado')->assertViewHas('orders', function ($orders) use ($payed, $notPayed){
            return  (true == $orders->contains($payed))
                && (false == $orders->contains($notPayed));
        });

        $this->get('orders?paymentStatus=sin_pagar')->assertViewHas('orders', function ($orders) use ($payed, $notPayed){
            return  (true == $orders->contains($notPayed))
                && (false == $orders->contains($payed));
        });

    }

    /** @test */
    public function it_filters_the_order_status_and_search(){

        $this->actingAs($this->getAdmin());
        $userPepe = $this->createUser('Pepe López');

        $collectedFirst = Order::factory()->collected()->create(['user_id' => $userPepe->id,'order_code' => 'h167',]);
        $collectedSecond = Order::factory()->collected()->create(['user_id' => $userPepe->id,'order_code' => 'h455',]);
        $readyToCollectFirst = Order::factory()->readyToCollect()->create(['user_id' => $userPepe->id,'order_code' => 'h490',]);
        $readyToCollectSecond = Order::factory()->readyToCollect()->create(['user_id' => $userPepe->id,'order_code' => 'b630',]);

        $this->get('orders?orderStatus=recogido&search=H4')
            ->assertViewHas('orders', function ($orders) use ($collectedFirst, $collectedSecond, $readyToCollectFirst, $readyToCollectSecond){
                return  (true == $orders->contains($collectedSecond))
                    && (false == $orders->contains($collectedFirst))
                    && (false == $orders->contains($readyToCollectFirst))
                    && (false == $orders->contains($readyToCollectSecond));
            });

        $this->get('orders?orderStatus=pendiente&search=H4')
            ->assertViewHas('orders', function ($orders) use ($collectedFirst, $collectedSecond, $readyToCollectFirst, $readyToCollectSecond){
                return  (true == $orders->contains($readyToCollectFirst))
                    && (false == $orders->contains($collectedFirst))
                    && (false == $orders->contains($collectedSecond))
                    && (false == $orders->contains($readyToCollectSecond));
            });

    }
}
