<?php


namespace App\Util;


trait OrderCodeGenerator
{
    public function generateOrderCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return  $characters[rand(0, strlen($characters) - 1)] .mt_rand(10000000, 99999999);
    }
}
