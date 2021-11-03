<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $orderStatus = Arr::random($this->getOrderStatus());

        return [
            'order_code' => $this->faker->randomLetter.$this->faker->numerify('###'),
            'order_status' => $orderStatus,
            'payment_status' => ($orderStatus == 'recogido')? 'ya_pagado': 'sin_pagar',
        ];
    }

    public function getOrderStatus()
    {
        return ['pendiente', 'recogido','no_recogido'];
    }
}
