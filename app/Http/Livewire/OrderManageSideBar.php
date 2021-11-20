<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Livewire\Component;

class OrderManageSideBar extends Component
{
    public $select;
    public $paginate = 10;
    public $search;
    public $orderStatus;


    protected $queryString = [
        'search' => ['except' => ''],
        'orderStatus' => ['except' => 'all'],
        ];

    protected $listeners = [
        'loadMore' => 'loadMore',
    ];

    public function loadMore()
    {
        $this->paginate += 10;
    }

    public function render()
    {
        $filters = [
            'search' => $this->search,
            'orderStatus' => $this->orderStatus
        ];

        $orders = Order::query()
            ->with('user', 'articles')
            ->applyFilters($filters)
            ->orderBy('created_at')
            ->whereDate('created_at', Carbon::today())
            ->paginate($this->paginate);

        return view('livewire.order-manage-side-bar',
            ['orders' => $orders]);
    }
}
