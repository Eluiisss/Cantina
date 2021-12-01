<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Gloudemans\Shoppingcart\Facades\Cart;
use Session;

use Illuminate\Http\Request;

class CartController extends Controller
{

    public function cart()  
    {
        $cart = Cart::content();
        return view('shop.cart',compact('cart'));  
    }

    public function store(Request $request){

        $article=Article::findOrFail($request->input('article_id'));
        Cart::add(
            $article->id,
            $article->name,
            1,
            $article->discounted_price,
            
        );
        Session::put($article->name, $article->image);
        
        return redirect('shop')->with('message','Artículo añadido correctamente');
    }

    public function findInCart($id){
        $cart = Cart::content();
        foreach ($cart as $art) {
            if ($art->id==$id)
            {
                return $art->rowId;
            }
        }

    }

    function deleteFromCart(Request $request){

        $article=Article::findOrFail($request->input('article_id'));
        $articleRow = $this->findInCart($article->id);

        Cart::remove($articleRow);

        return redirect('shop')->with('message','Artículo eliminado correctamente');

    }
    
}