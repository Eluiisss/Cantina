<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{

    public function index()
    {
        $articles = Article::query()
            ->with('category')
            ->with(['nutrition' => function ($q) {
                $q->withTrashed();
            }])->onlyTrashedIf(request()->routeIs('articles.trashed'))
            ->orderBy('name')
            ->applyFilters()
            ->paginate();

        return view('articles.index', [
            'view' => request()->routeIs('articles.trashed') ? 'trash' : 'index',
            'articles'=> $articles,
            'categories' => Category::query()
                            ->with('articles')
                            ->whereHas('articles')
                            ->orderBy('name', 'ASC')->get(),
            ]);
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
