<?php

namespace Tests\Feature\Admin\OrdersTest;

use Admin\OrdersTest\BaseOrdersTest;
use App\Http\Livewire\OrderManageSideBar;
use App\Models\Order;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterManageOrdersTest extends TestCase
{
    use RefreshDatabase, BaseOrdersTest;

    /** @test */
    public function it_loads_the_manage_orders_list_page_with_filters()
    {
        $this->get(route('orders.manage'))
            ->assertStatus(200)
            ->assertSee(trans('orders.manage.filters.order'));
    }

    /** @test */
    public function it_filters_the_order_status()
    {
        $userPepe = $this->createUser('Pepe López');

        $collected = Order::factory()->collected()->create(['user_id' => $userPepe->id,]);
        $readyToCollect = Order::factory()->readyToCollect()->create(['user_id' => $userPepe->id,]);
        $notCollected = Order::factory()->notCollected()->create(['user_id' => $userPepe->id,]);

        Livewire::test(OrderManageSideBar::class)->set('orderStatus', 'recogido')->assertViewHas('orders', function ($orders) use ($collected, $readyToCollect, $notCollected){
            return  (true == $orders->contains($collected))
                && (false == $orders->contains($readyToCollect))
                && (false == $orders->contains($notCollected));
        });

        Livewire::test(OrderManageSideBar::class)->set('orderStatus', 'pendiente')->assertViewHas('orders', function ($orders) use ($collected, $readyToCollect, $notCollected){
            return  (true == $orders->contains($readyToCollect))
                && (false == $orders->contains($collected))
                && (false == $orders->contains($notCollected));
        });

        Livewire::test(OrderManageSideBar::class)->set('orderStatus', 'no_recogido')->assertViewHas('orders', function ($orders) use ($collected, $readyToCollect, $notCollected){
            return  (true == $orders->contains($notCollected))
                && (false == $orders->contains($readyToCollect))
                && (false == $orders->contains($collected));
        });
    }

    /** @test */
    public function it_filters_the_order_status_and_search(){
        $userPepe = $this->createUser('Pepe López');

        $collectedFirst = Order::factory()->collected()->create(['user_id' => $userPepe->id,'order_code' => 'h167',]);
        $collectedSecond = Order::factory()->collected()->create(['user_id' => $userPepe->id,'order_code' => 'h455',]);
        $readyToCollectFirst = Order::factory()->readyToCollect()->create(['user_id' => $userPepe->id,'order_code' => 'h490',]);
        $readyToCollectSecond = Order::factory()->readyToCollect()->create(['user_id' => $userPepe->id,'order_code' => 'b630',]);

        Livewire::test(OrderManageSideBar::class)
            ->set('orderStatus', 'recogido')
            ->set('search', 'H4')
            ->assertViewHas('orders', function ($orders) use ($collectedFirst, $collectedSecond, $readyToCollectFirst, $readyToCollectSecond){
            return  (true == $orders->contains($collectedSecond))
                && (false == $orders->contains($collectedFirst))
                && (false == $orders->contains($readyToCollectFirst))
                && (false == $orders->contains($readyToCollectSecond));
        });

        Livewire::test(OrderManageSideBar::class)
            ->set('orderStatus', 'pendiente')
            ->set('search', 'H4')
            ->assertViewHas('orders', function ($orders) use ($collectedFirst, $collectedSecond, $readyToCollectFirst, $readyToCollectSecond){
                return  (true == $orders->contains($readyToCollectFirst))
                    && (false == $orders->contains($collectedFirst))
                    && (false == $orders->contains($collectedSecond))
                    && (false == $orders->contains($readyToCollectSecond));
            });

    }

}
