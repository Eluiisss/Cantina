<?php


namespace App\Filters;


use Illuminate\Support\Carbon;

class OrderFilter extends QueryFilter
{
    public function rules(): array
    {
        return [
            'search' => 'filled',
            'orderStatus' => 'in:no_recogido,pendiente,recogido',
            'paymentStatus' =>'in:sin_pagar,ya_pagado',
            'dailyOrders' => 'boolean',
        ];
    }

    public function search($query, $search)
    {
        return $query->where(function ($query) use ($search){
            return $query->where('order_code', 'like', "%$search%")
                ->orWhereHas('user', function ($query) use ($search){
                return $query->where('name', 'like', "%$search%");
            });
        });
    }

    public function orderStatus($query, $status)
    {
        return $query->where('order_status', $status);
    }

    public function paymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    public function dailyOrders($query, $status)
    {
        if($status){
            return  $query->whereDate('created_at', Carbon::today());
        }else {
            return $query;
        }
    }
}
