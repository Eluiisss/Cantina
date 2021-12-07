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

    public $selectedProduct;
    public $showShop = '';
    public $productModal = 'hidden';

    public $paginate = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'veg' => ['except' => ''],
        'allergy' => ['except' => ''],
    ];

    public function openProductModal($id)
    {
        $this->selectedProduct = $id;
        $this->productModal = true;
        $this->showShop = 'hidden';
    }

    public function closeProductModal()
    {
        $this->selectedProduct = null;
        $this->productModal = 'hidden';
        $this->showShop = '';
    }

    public function loadMoreProducts()
    {
        $this->paginate += 10;
    }

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
            ->paginate($this->paginate);

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
