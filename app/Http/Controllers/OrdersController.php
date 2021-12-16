<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Article;
use App\Util\OrderCodeGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;



class OrdersController extends Controller
{
    use OrderCodeGenerator;

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
        if (Auth::user()->banned == 0){
            try {
                DB::transaction(function () {
                    $date = now();
                    $cart= Cart::content();
                    $order = Order::create([
                        'user_id' => Auth::id(),
                        'order_code' => $this->generateOrderCode(),
                        'created_at' => $date,
                        'order_status' => 'pendiente',
                        'payment_status' => 'ya_pagado',
                        'payment_date' => now(),
                        'total_payed' => Cart::priceTotal(),
                        'client_note' => session('client_note')

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
                    session(['client_note' => null]);
                    $user->credit=$newCredit;
                    $user->save();

                });
            } catch (\Exception $e) {
                return redirect('shop')->with('message','Error en el encargo');
            }

            return redirect('shop')->with('message','¡Encargo pagado!');
        }else{
            return redirect('shop')->with('message','Usuario deshabilitado, contacte con cantina');
        }

    }

    public function createNewOrder(){

        if (Auth::user()->banned == 0){ //si está baneado banned = 1
            try {
                DB::transaction(function () {
                    $date = now();
                    $cart= Cart::content();
                    $order = Order::create([
                        'user_id' => Auth::id(),
                        'order_code' => $this->generateOrderCode(),
                        'created_at' => $date,
                        'order_status' => 'pendiente',
                        'payment_status' => 'sin_pagar',
                        'client_note' => session('client_note')

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
                    session(['client_note' => null]);
                });
            } catch (\Exception $e) {
                return redirect('shop')->with('message','Error en el encargo');
            }
            return redirect('shop')->with('message','¡Encargo Realizado!');
        }else{
            return redirect('shop')->with('message','Usuario deshabilitado, contacte con cantina');
        }
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
