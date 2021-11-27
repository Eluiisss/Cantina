<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_a_404_error_if_the_article_is_not_found()
    {
        $this->withExceptionHandling();
        $this->actingAs($this->getAdmin())->get(route('articles.show', ['article' => 999]))
            ->assertStatus(404);
    }

    /** @test */
    public function it_loads_the_articles_details_page()
    {
        $category = Category::factory()->create();
        $article = Article::factory()->create([
            'category_id' => $category->id
        ]);

        $article->nutrition()->update([
            'is_allergy' => true,
            'allergy_description' => "No apto para celiacos"
        ]);

        $this->actingAs($this->getAdmin())->get(route('articles.show', ['article' => $article->id]))
            ->assertOk()
            ->assertSeeInOrder([
                $article->name,
                $article->category->name,
                $article->price,
                $article->stock,
                $article->nutrition->proteins,
                $article->nutrition->sodium,
                $article->nutrition->calories,
                $article->nutrition->ingredients_description,
                $article->nutrition->allergy_description
            ]);
    }
}
