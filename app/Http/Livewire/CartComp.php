<?php

namespace App\Http\Livewire;
use App\Models\Article;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;
use Livewire\Component;


class CartComp extends Component
{
    public $client_note = '';

    public function render()
    {
        $cart = Cart::content();
        return view('livewire.cart-comp', compact('cart'));
    }

    public function setClientNote()
    {
        session(['client_note' => Str::substr($this->client_note, 0, 1000)]);
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
