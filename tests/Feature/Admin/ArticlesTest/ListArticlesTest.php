<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListArticlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function it_shows_the_articles_list()
    {
        $category = Category::factory()->create(['name' => 'Comida']);

        Article::factory()->create(['name' => 'Pizza', 'category_id' => $category->id]);
        Article::factory()->create(['name' => 'Zumo Brick', 'category_id' => $category->id]);
        Article::factory()->create(['name' => 'Croissant', 'category_id' => $category->id]);

        $response = $this->get(route('articles.index'));
        $response->assertStatus(200);

        $response->assertSee(trans('articles.title.index'));

        $response->assertSeeInOrder([
            'Croissant',
            'Pizza',
            'Zumo Brick'
        ]);

        $this->assertNotRepeatedQueries();
    }

    /** @test  */
    public function shows_a_default_message_is_articles_list_is_empty()
    {
        $this->assertDatabaseEmpty('articles');
        $response = $this->get(route('articles.index'))->assertStatus(200);
        $response->assertSee('Sin datos');
    }

    /** @test  */
    public function it_paginate_the_articles()
    {
        $category = Category::factory()->create(['name' => 'Comida']);

        Article::factory()->create(['name' => 'Pizza', 'category_id' => $category->id]);
        Article::factory()->create(['name' => 'Zumo Brick', 'category_id' => $category->id]);
        Article::factory()->times(15)->create(['category_id' => $category->id]);
        Article::factory()->create(['name' => 'Agua', 'category_id' => $category->id]);

        $response = $this->get(route('articles.index', ['page'=>'1']))->assertStatus(200);
        $response->assertSeeInOrder(['Agua', 'Pizza']);
        $response->assertDontSee('Zumo Brick');

        $response = $this->get(route('articles.index', ['page'=>'2']))->assertStatus(200);
        $response->assertSee('Zumo Brick');
        $response->assertDontSee('Agua');
        $response->assertDontSee('Pizza');

    }
}
