<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderUserHistory extends Component
{

    protected $selectedOrder;
    protected $orderModal = 'hidden';

    public function openOrderModal($id)
    {
        $this->selectedOrder = $id;
        $this->orderModal = '';
    }

    public function closeOrderModal()
    {
        $this->selectedOrder = null;
        $this->orderModal = 'hidden';
    }

    public function render()
    {
        $orders = Order::query()
            ->with('user', 'articles')
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at')
            ->get();

        return view('livewire.order-user-history',
            [
            'orders' => $orders,
            'orderModal' => $this->orderModal,
            'selectedOrder' => $this->selectedOrder
            ]);
    }
}
