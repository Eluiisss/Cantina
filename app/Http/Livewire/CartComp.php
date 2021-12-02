<?php

namespace App\Http\Livewire;
use App\Models\Article;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartComp extends Component
{
    public function render()
    {
        $cart = Cart::content();
        return view('livewire.cart-comp', compact('cart'));
    }

    public function lessQty($rowId)
    {
        $article= Cart::get($rowId);
        if($article->qty != 1){
            $newQty = $article->qty - 1;
            Cart::update($rowId,$newQty);
        }
        
    }

    public function moreQty($rowId)
    {
        $article= Cart::get($rowId);
        $newQty = $article->qty + 1;
        Cart::update($rowId,$newQty);
    }

    public function delete($rowId)
    {
        Cart::remove($rowId);
    }
}