<?php

namespace Tests\Feature\Admin\ShopTest;

use App\Models\Article;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListArticlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function it_shows_the_shop_view(){

        $category = Category::factory()->create(['name' => 'Comida']);

        Article::factory()->create(['name' => 'Pizza', 'discounted_price' => 1.70, 'category_id' => $category->id]);
        Article::factory()->create(['name' => 'Zumo Brick' ,'discounted_price' => 1.10, 'category_id' => $category->id]);
        Article::factory()->create(['name' => 'Croissant','discounted_price' => 2.50, 'category_id' => $category->id]);

        $response = $this->get(route('shop.index'));
        $response->assertStatus(200);

       $response->assertSee(trans('Bienvenido a la cantina'));

        $response->assertSeeInOrder([
            'Croissant',
            '2.50',
            'Pizza',
            '1.70',
            'Zumo Brick',
            '1.10'
        ]);
    }

    /** @test  */
    public function shows_a_default_message_is_shop_list_is_empty()
    {
        $this->assertDatabaseEmpty('articles');
        $response = $this->get(route('shop.index'))->assertStatus(200);
        $response->assertSee('No hay productos disponibles por el momento. ¡Disculpe las molestias!');
    }

    /** @test  */
    public function only_show_products_with_stock()
    {
        $category = Category::factory()->create(['name' => 'Comida']);

        Article::factory()->create(['name' => 'Pizza', 'stock' => 0, 'category_id' => $category->id]);
        Article::factory()->create(['name' => 'Zumo Brick' ,'stock' => 10, 'category_id' => $category->id]);

        $this->get(route('shop.index'))
        ->assertOk()
        ->assertSee('Zumo Brick')
        ->assertDontSee('Pizza');
    }

    /** @test  */
    public function it_paginate_the_shop_articles()
    {
        $category = Category::factory()->create(['name' => 'Comida']);

        Article::factory()->create(['name' => 'Pizza', 'category_id' => $category->id]);
        Article::factory()->create(['name' => 'Zumo Brick', 'category_id' => $category->id]);
        Article::factory()->times(15)->create(['category_id' => $category->id]);
        Article::factory()->create(['name' => 'Agua', 'category_id' => $category->id]);

        $response = $this->get(route('shop.index', ['page'=>'1']))->assertStatus(200);
        $response->assertSeeInOrder(['Agua', 'Pizza']);
        $response->assertDontSee('Zumo Brick');

        $response = $this->get(route('shop.index', ['page'=>'2']))->assertStatus(200);
        $response->assertSee('Zumo Brick');
        $response->assertDontSee('Agua');
        $response->assertDontSee('Pizza');

    }

}
