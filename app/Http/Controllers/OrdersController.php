<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;


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

    public function createNewOrder(){

            $date = now();
            $cart= Cart::content();

            $order = Order::create([
                'user_id' => Auth::id(),
                'created_at' => $date,
                'order_code' => 'a111',//cambiar
                'order_status' => 'pendiente',
                'payment_status' => 'sin_pagar',

            ]);

            foreach ($cart as $art) {
                $order->articles()
                ->attach($art->id, [
                'quantity' => $art->qty,
                'created_at' => $date,
                'updated_at' => $date,

            ]);

            }
            Cart::destroy();
            return redirect('shop')->with('message','¡Encargo Realizado!');
    }


    public function createPayedOrder(){
        $date = now();
        $cart= Cart::content();
        $user=Auth::user();
        $newCredit = $user->credit - Cart::priceTotal();

        $order = Order::create([
            'user_id' => $user->id,
            'created_at' => $date,
            'order_code' => 'a222',
            'order_status' => 'pendiente',
            'payment_status' => 'ya_pagado',

        ]);

        foreach ($cart as $art) {
            $order->articles()
            ->attach($art->id, [
            'quantity' => $art->qty,
            'created_at' => $date,
            'updated_at' => $date,

        ]);

        $user->credit=$newCredit;
        $user->save();
        Cart::destroy();
        return redirect('shop')->with('message','¡Encargo pagado!');

        }


    }


}
