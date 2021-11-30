<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Shop;
use App\Models\User;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Gloudemans\Shoppingcart\Facades\Cart;
use Session;
use Stripe;

class ShopController extends Controller
{

    public function index()
    {
        return view('shop.index');
    }

    public function show(Article $article)
    {
        return view('shop.show', compact('article'));
    }

    public function checkout()
    {
        return view('shop.checkout');
    }

    public function paymentAction(Request $request) {

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $request->session()->get('totalPayment') * 100,
                "currency" => "eur",
                "source" => $request->stripeToken,
                "description" => "Test payment from cantina.com.",
        ]);

        Session::flash('success', 'Payment successful!');

        return back();
    }

}
