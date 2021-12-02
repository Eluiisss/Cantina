<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Service\Paypal;

class PaypalController extends Controller
{
    public function create( Request $request){
        $data = json_decode($request->getContent(),true);

        //inicializamos paypal
        $provider = \Paypal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $price = 20;
        $description = 'mucho';

        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" =>[
                [
                "currency_code"   =>'EUR',
                "value" => $price
                ],
                "description" =>"description"
            ]
        ]);

        //return response()->json($order);

    }
}
