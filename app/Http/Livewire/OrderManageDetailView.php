<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderManageDetailView extends Component
{
    public $order;
    public $orderId;

    protected $listeners = [
        'orderSelected' => 'setOrderId'
    ];

    public function setOrderId($id)
    {
        $this->orderId = $id;
    }
    public function render()
    {
        $this->order = Order::query()
            ->with('user', 'articles')
            ->whereId($this->orderId)
            ->first();

        return view('livewire.order-manage-detail-view');
    }
}
