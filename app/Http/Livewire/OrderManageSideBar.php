<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderManageSideBar extends Component
{
    public $select;
    public $paginate = 10;
    public $search;
    public $orderStatus;
    public $daily = true;


    protected $queryString = [
        'search' => ['except' => ''],
        'orderStatus' => ['except' => 'all'],
        ];

    protected $listeners = [
        'loadMore' => 'loadMore',
        'orderSelected' => 'orderSelected'
    ];

    public function orderSelected($id){
        $this->select = $id;
    }

    public function loadMore()
    {
        $this->paginate += 10;
    }

    public function render()
    {
        $filters = [
            'search' => $this->search,
            'orderStatus' => $this->orderStatus,
            'dailyOrders' => $this->daily
        ];

        $orders = Order::query()
            ->with('user', 'articles')
            ->applyFilters($filters)
            ->orderBy('created_at')
            ->paginate($this->paginate);

        return view('livewire.order-manage-side-bar',
            ['orders' => $orders]);
    }
}
