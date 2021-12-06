<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;



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

    public function createPayedOrder(){



            DB::transaction(function () {
                $date = now();
                $cart= Cart::content();
                $order = Order::factory()->create([
                    'user_id' => Auth::id(),
                    'created_at' => $date,
                    'order_status' => 'pendiente',
                    'payment_status' => 'ya_pagado',
                    'total_payed' => Cart::priceTotal(),

                ]);

                foreach ($cart as $art) {
                    $order->articles()
                    ->attach($art->id, [
                    'quantity' => $art->qty,
                    'created_at' => $date,
                    'updated_at' => $date,

                ]);

                }
                $user=Auth::user();
                $newCredit = $user->credit - Cart::priceTotal();
                Cart::destroy();
                $user->credit=$newCredit;
                $user->save();
                return redirect('shop')->with('message','¡Encargo pagado!');
            });
            return redirect('shop')->with('message','Error en el encargo');
    }

    public function createNewOrder(){



        DB::transaction(function () {
            $date = now();
            $cart= Cart::content();
            $order = Order::factory()->create([
                'user_id' => Auth::id(),
                'created_at' => $date,
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
        });
        return redirect('shop')->with('message','Error en el encargo');
    }

    public function cancel($id){
        $order= Order::find($id);
        $order->order_status = 'cancelado';
        $user = User::find($order->user_id);
        if($order->total_payed){
            $user->credit += $order->total_payed;
            $user->save();
        }
        $order->save();
        return redirect('pedidos');
    }



}
