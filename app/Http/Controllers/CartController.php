<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request){

        $article=Article::findOrFail($request->input('article_id'));
        Cart::add(
            $article->id,
            $article->name,
            1,
            $article->discounted_price / 100, // /100
        );
        return redirect('shop')->with('message','Artículo añadido correctamente');
    }
}
