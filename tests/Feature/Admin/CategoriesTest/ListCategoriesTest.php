<?php

namespace Tests\Feature\Admin\CategoriesTest;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function it_shows_the_category_list()
    {
       Category::factory()->create(['name' => 'Snacks']);
       Category::factory()->create(['name' => 'Bebidas']);
       Category::factory()->create(['name' => 'Bollería']);

        $response = $this->actingAs($this->getAdmin())->get(route('categories.index'));
        $response->assertStatus(200);

        $response->assertSee(trans('categories.title.index'));

        $response->assertSeeInOrder([
            'Bebidas',
            'Bollería',
            'Snacks'
        ]);
    }

    /** @test  */
    public function shows_a_default_message_is_category_list_is_empty()
    {
        $this->assertDatabaseEmpty('categories');
        $response = $this->actingAs($this->getAdmin())->get(route('categories.index'))->assertStatus(200);
        $response->assertSee('Sin datos');
    }

    /** @test  */
    public function it_paginate_the_categories()
    {
        Category::factory()->create(['name' => 'Zabroso']);
        Category::factory()->times(15)->create();
        Category::factory()->create(['name' => 'Bollería']);
        Category::factory()->create(['name' => 'Bebidas']);

        $response = $this->actingAs($this->getAdmin())->get(route('categories.index', ['page'=>'1']))->assertStatus(200);
        $response->assertSeeInOrder(['Bebidas', 'Bollería']);
        $response->assertDontSee('Zabroso');

        $response = $this->actingAs($this->getAdmin())->get(route('categories.index', ['page'=>'2']))->assertStatus(200);
        $response->assertSee('Zabroso');
        $response->assertDontSee('Bollería');
        $response->assertDontSee('Bebidas');
    }
}
