<?php

namespace Tests\Feature\Admin\ArticlesTest;

use App\Models\Article;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchArticlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function search_articles_by_name(){
        $category = Category::factory()->create();

        $agua = Article::factory()->create(['category_id' => $category->id, 'name' => 'Agua']);
        $pizza = Article::factory()->create(['category_id' => $category->id, 'name' => 'Pizza']);

        $this->get(route('articles.index', ['search' => 'Pizza']))
            ->assertViewCollection('articles')
            ->contains($pizza)
            ->notContains($agua);
    }

    /** @test */
    public function partial_search_articles_by_name(){
        $category = Category::factory()->create();

        $agua = Article::factory()->create(['category_id' => $category->id, 'name' => 'Agua']);
        $aguacola = Article::factory()->create(['category_id' => $category->id, 'name' => 'Aguacola']);
        $pizza = Article::factory()->create(['category_id' => $category->id, 'name' => 'Pizza']);

        $this->get(route('articles.index', ['search' => 'Agua']))
            ->assertViewCollection('articles')
            ->contains($agua)
            ->contains($aguacola)
            ->notContains($pizza);
    }

    /** @test */
    public function search_articles_by_category_name(){

        $bebida = Category::factory()->create(['name' => 'Bebidas']);
        $snack = Category::factory()->create(['name' => 'Snacks']);
        $agua = Article::factory()->create(['category_id' => $bebida->id]);
        $pizza= Article::factory()->create(['category_id' => $snack->id]);

        $this->get(route('articles.index', ['search' => 'Bebidas']))
            ->assertViewCollection('articles')
            ->contains($agua)
            ->notContains($pizza);

    }

    /** @test */
    public function partial_search_articles_by_category_name(){

        $bebida = Category::factory()->create(['name' => 'Bebidas']);
        $snack = Category::factory()->create(['name' => 'Snacks']);
        $agua = Article::factory()->create(['category_id' => $bebida->id]);
        $pizza= Article::factory()->create(['category_id' => $snack->id]);

        $this->get(route('articles.index', ['search' => 'Sna']))
            ->assertViewCollection('articles')
            ->contains($pizza)
            ->notContains($agua);
    }

    /** @test */
    public function search_articles_by_allergy_description(){
        $category = Category::factory()->create();

        $gluten = Article::factory()->create(['category_id' => $category->id]);
        $avellanas = Article::factory()->create(['category_id' => $category->id]);

        $gluten->nutrition()->update([
            'is_allergy' => true,
            'allergy_description' => 'Gluten Voluptatibus fugiat in sint rem aut quos et sunt voluptates ad reiciendis.'
        ]);

        $avellanas->nutrition()->update([
            'is_allergy' => true,
            'allergy_description' => 'Avellanas Voluptatibus fugiat in sint rem aut quos et sunt voluptates ad reiciendis.'
        ]);

        $this->get(route('articles.index', ['search' => 'Avellanas']))
            ->assertViewCollection('articles')
            ->contains($avellanas)
            ->notContains($gluten);
    }

    /** @test */
    public function partial_search_articles_by_allergy_description(){
        $category = Category::factory()->create();

        $gluten = Article::factory()->create(['category_id' => $category->id]);
        $avellanas = Article::factory()->create(['category_id' => $category->id]);

        $gluten->nutrition()->update([
            'is_allergy' => true,
            'allergy_description' => 'Gluten Voluptatibus fugiat in sint rem aut quos et sunt voluptates ad reiciendis.'
        ]);

        $avellanas->nutrition()->update([
            'is_allergy' => true,
            'allergy_description' => 'Avellanas Voluptatibus fugiat in sint rem aut quos et sunt voluptates ad reiciendis.'
        ]);

        $this->get(route('articles.index', ['search' => 'Glut']))
            ->assertViewCollection('articles')
            ->contains($gluten)
            ->notContains($avellanas);
    }
}
