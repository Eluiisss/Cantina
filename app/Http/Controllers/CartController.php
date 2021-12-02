<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::check()) {
            $article=Article::findOrFail($request->input('article_id'));
            Cart::add(
                $article->id,
                $article->name,
                1,
                $article->discounted_price,
                
            );
            //$artImg=$article->name;
            Session::put([$article->name.''.$article->id => $article->image]);
            //dd( Session::get($article->name.''.$article->id));
            return redirect('shop')->with('message','Artículo añadido correctamente');
        }else  {
            return redirect('shop')->with('message','¡Inicie sesión o cree una cuenta para comprar!');
        }
        
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
        
        Session::forget($article->name.''.$article->id);
        Cart::remove($articleRow);

        return redirect('shop')->with('message','Artículo eliminado correctamente');

    }
    
}
