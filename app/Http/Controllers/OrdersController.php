<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    public function index()
    {
        $orders = Order::query()
            ->orderBy('created_at')
            ->with('user', 'articles')
            ->applyFilters()
            ->paginate();

        return view('orders.index', compact('orders'));
    }

    public function manageOrders()
    {
        return view('orders.manage');
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

}
