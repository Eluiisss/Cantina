<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\Category;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class ShopProdcuts extends Component
{

    public $search;
    public $category;
    public $veg;
    public $allergy;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'veg' => ['except' => ''],
        'allergy' => ['except' => ''],
    ];

    public function filterCategory($name){
        if($this->category == $name){
            $name = null;
        }
            $this->category = $name;
    }

    public function render()
    {
        $filters = [
            'search' => $this->search,
            'category' => $this->category,
            'veg' => ($this->veg == true)? 'veg': null,
            'allergy' => ($this->allergy == true)? 'nonallergy': null,
        ];

        $cart = Cart::content();
        $articles = Article::query()
            ->with('nutrition', 'category')
            ->where('stock','>', 0)
            ->applyFilters($filters)
            ->orderBy('name')
            ->paginate();

        return view('livewire.shop-prodcuts',
            [
                'cart' => $cart,
                'articles' => $articles,
                'categories' => Category::query()
                    ->with('articles')
                    ->whereHas('articles')
                    ->orderBy('name', 'ASC')->get(),
            ]);

    }
}
