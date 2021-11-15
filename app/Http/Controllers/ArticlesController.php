<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::query()
            ->with('nutrition', 'category')
            ->onlyTrashedIf(request()->routeIs('articles.trashed'))
            ->orderBy('name')
            ->paginate();

        return view('articles.index', compact('articles'));
    }

    public function cart()  
    {
        return view('articles.cart');  
    }

    public function addToCart($id)
    {
        $article = Article::find($id);
   
        if(!$article) {
   
            abort(404);
   
        }
        $cart = session()->get('cart');  
   
        // vacio
        if(!$cart) {
   
            $cart = [
                    $id => [
                        "name" => $article->name,
                        "quantity" => 1,
                        "price" => $article->discounted_price,
                        //"image" => $article->image
                    ]
            ];
   
            session()->put('cart', $cart);
   
            return redirect()->back()->with('success', 'added to cart successfully!');
        }
   
        // no vacio
        if(isset($cart[$id])) {
   
            $cart[$id]['quantity']++;
   
            session()->put('cart', $cart); // this code put article of choose in cart
   
            return redirect()->back()->with('success', 'article added to cart successfully!');
   
        }
   
        // primer articulo de ese tipo
        $cart[$id] = [
            "name" => $article->name,
            "quantity" => 1,
            "price" => $article->discounted_price,
            //"image" => $article->image
        ];
   
        session()->put('cart', $cart);
   
        return redirect()->back()->with('success', 'Añadido correctamente');
        
    }

    public function updateCart(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;

            session()->put('cart', $cart);

            session()->flash('success', 'Actualizado correctamente');
        }
    }

    public function removeFromCart(Request $request)
    {
        if($request->id) {

            $cart = session()->get('cart');

            if(isset($cart[$request->id])) {

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }

            session()->flash('success', 'Eliminado correctamente');
        }
    }


    public function create(Article $article)
    {
        return view('articles.create', [
            'article' => $article,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(CreateArticleRequest $request)
    {
        $request->createNewArticle();
        return redirect(route('articles.index'));
    }


    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }


    public function edit(Article $article)
    {
        return view('articles.edit', [
            'article' => $article,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $request->updateArticle($article);
        return redirect(route('articles.show', ['article' => $article]));
    }

    public function trash(Article $article)
    {
        DB::transaction(function () use($article) {
            $article->nutrition()->delete();
            $article->delete();
        });

        return redirect(route('articles.index'));
    }

    public function restore($id)
    {
        $article = Article::onlyTrashed()->where('id', $id)->firstOrFail();

        DB::transaction(function () use($article) {
            $article->nutrition()->restore();
            $article->restore();
        });

        return redirect(route('articles.index'));
    }

    public function destroy($id)
    {
        $article = Article::onlyTrashed()->where('id', $id)->firstOrFail();
        $article->forceDelete();
        return redirect()->route('articles.trashed');
    }
}
