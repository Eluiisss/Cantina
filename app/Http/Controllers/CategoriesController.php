<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::query()
            ->with('articles')
            ->orderBy('name')
            ->applyFilters()
            ->paginate();

        return view('categories.index', compact('categories'));
    }


    public function create(Category $category)
    {
        return view('categories.create', [
            'category' => $category,
        ]);
    }


    public function store(CreateCategoryRequest $request)
    {
       $request->createNewCategory();
        return redirect(route('categories.index'));
    }


    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $request->updateCategory($category);
        return redirect(route('categories.show', ['category' => $category]));
    }

    public function destroy( $id)
    {
        $category = Category::query()->where('id', $id)->firstOrFail();
        abort_if($category->articles()->exists(), 400, 'No puedes borrar una categoría con articulos');
        $category->forceDelete();
        return redirect()->route('categories.index');
    }
}
