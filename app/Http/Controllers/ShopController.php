<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Shop;

class ShopController extends Controller
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
            ->where('stock','>', 0)
            ->orderBy('name')
            ->paginate();
        return view('shop.index', compact('articles'));
    }

    public function show(Article $article)
    {
        return view('shop.show', compact('article'));
    }

}
