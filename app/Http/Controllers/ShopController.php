<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Shop;
use App\Models\User;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
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
        $cart = Cart::content();
        return view('shop.show', compact('article','cart'));
    }




}
