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
            'payment_date' => ($orderStatus == 'recogido')? now(): null,
            'collected_date' => ($orderStatus == 'recogido')? now(): null,
        ];
    }

    public function getOrderStatus()
    {
        return ['pendiente', 'recogido','no_recogido'];
    }

    public function readyToCollect()
    {
        return $this->state(function ($faker) {
            return [
                'order_status' => 'pendiente',
            ];
        });
    }

    public function collected()
    {
        return $this->state(function ($faker) {
            return [
                'order_status' => 'recogido',
            ];
        });
    }

    public function notCollected()
    {
        return $this->state(function ($faker) {
            return [
                'order_status' => 'no_recogido',
            ];
        });
    }

    public function alreadyPayed()
    {
        return $this->state(function ($faker) {
            return [
                'payment_status' => 'ya_pagado',
                'payment_date' => now(),
            ];
        });
    }

    public function notPayedYet()
    {
        return $this->state(function ($faker) {
            return [
                'payment_status' => 'sin_pagar',
                'payment_date' => null,
            ];
        });
    }
}
