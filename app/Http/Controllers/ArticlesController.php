<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

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
            ->orderBy('id', 'DESC')
            ->paginate();

        return view('articles.index', compact('articles'));
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

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
