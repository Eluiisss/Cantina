<?php

namespace Tests\Feature\Admin\OrdersTest;

use App\Http\Livewire\OrderManageSideBar;
use App\Models\Nre;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchManageOrdersTest extends TestCase
{
    use RefreshDatabase;

    protected $role;

    /** @test */
    public function search_order_by_order_code()
    {
        $userPepe = $this->createUser('Pepe López');

        $firstOrder = Order::factory()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'b123',
            ]);

        $secondOrder = Order::factory()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'a456',
        ]);

        Livewire::test(OrderManageSideBar::class)->set('search', 'B123')->assertViewHas('orders', function ($orders) use ($firstOrder, $secondOrder){
            return  (true == $orders->contains($firstOrder))
                && (false == $orders->contains($secondOrder));
        });
    }

    /** @test */
    public function search_order_by_partial_order_code(){

        $userPepe = $this->createUser('Pepe López');

        $firstOrder = Order::factory()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'b123',
        ]);

        $secondOrder = Order::factory()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'a456',
        ]);

        $thirdOrder = Order::factory()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'b170',
        ]);

        Livewire::test(OrderManageSideBar::class)->set('search', 'B1')->assertViewHas('orders', function ($orders) use ($firstOrder, $secondOrder, $thirdOrder){
            return  (true == $orders->contains($firstOrder)) &&
                (true == $orders->contains($thirdOrder))
                && (false == $orders->contains($secondOrder));
        });
    }

    /** @test */
    public function search_order_by_user_name()
    {
        $userPepe = $this->createUser('Pepe López');
        $userJuan = $this->createUser('Juan López');

        $firstOrder = Order::factory()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'b123',
        ]);

        $secondOrder = Order::factory()->create([
            'user_id' => $userJuan->id,
            'order_code' => 'a456',
        ]);

        Livewire::test(OrderManageSideBar::class)->set('search', 'Pepe López')->assertViewHas('orders', function ($orders) use ($firstOrder, $secondOrder){
            return  (true == $orders->contains($firstOrder))
                && (false == $orders->contains($secondOrder));
        });
    }

    /** @test */
    public function search_order_by_partial_user_name(){


        $userPepe = $this->createUser('Pepe López');
        $userJuan = $this->createUser('Juan López');
        $userPepe2 = $this->createUser('Pepe García');

        $firstOrder = Order::factory()->create([
            'user_id' => $userPepe->id,
            'order_code' => 'b123',
        ]);

        $secondOrder = Order::factory()->create([
            'user_id' => $userJuan->id,
            'order_code' => 'a456',
        ]);

        $thirdOrder = Order::factory()->create([
            'user_id' => $userPepe2->id,
            'order_code' => 'b170',
        ]);

        Livewire::test(OrderManageSideBar::class)->set('search', 'Pepe')->assertViewHas('orders', function ($orders) use ($firstOrder, $secondOrder, $thirdOrder){
            return  (true == $orders->contains($firstOrder)) &&
                (true == $orders->contains($thirdOrder))
                && (false == $orders->contains($secondOrder));
        });
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

    private function createUserRole(): void
    {
        $this->role = Role::create([
            'name' => 'user',
            'display_name' => 'User ',
            'description' => 'User is not allowed to manage and edit other users',
        ]);
    }
}
