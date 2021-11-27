<?php

namespace Tests\Feature\Admin\CategoriesTest;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function search_category_by_name(){

        $snacks = Category::factory()->create(['name' => 'Snacks']);
        $bebidas = Category::factory()->create(['name' => 'Bebidas']);

        $this->actingAs($this->getAdmin())->get(route('categories.index', ['search' => 'Snacks']))
            ->assertViewCollection('categories')
            ->contains($snacks)
            ->notContains($bebidas);
    }

    /** @test */
    public function partial_search_category_by_name(){

        $snacks = Category::factory()->create(['name' => 'Snacks']);
        $bebidas = Category::factory()->create(['name' => 'Bebidas']);

        $this->actingAs($this->getAdmin())->get(route('categories.index', ['search' => 'Beb']))
            ->assertViewCollection('categories')
            ->contains($bebidas)
            ->notContains($snacks);
    }

    /** @test */
    public function search_category_by_description(){

        $snacks = Category::factory()->create(['description' => 'Salados, patatas, etc']);
        $bebidas = Category::factory()->create(['description' => 'Agua, cafe, zumos entre otros']);

        $this->actingAs($this->getAdmin())->get(route('categories.index', ['search' => 'Agua, cafe, zumos entre otros']))
            ->assertViewCollection('categories')
            ->contains($bebidas)
            ->notContains($snacks);
    }

    /** @test */
    public function partial_search_category_by_description(){

        $snacks = Category::factory()->create(['description' => 'Salados, patatas, etc']);
        $bebidas = Category::factory()->create(['description' => 'Agua, cafe, zumos entre otros']);

        $this->actingAs($this->getAdmin())->get(route('categories.index', ['search' => 'patatas']))
            ->assertViewCollection('categories')
            ->contains($snacks)
            ->notContains($bebidas);
    }
}
