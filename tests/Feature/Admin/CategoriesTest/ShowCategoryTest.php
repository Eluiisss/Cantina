<?php

namespace Tests\Feature\Admin\CategoriesTest;

use App\Models\Article;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_a_404_error_if_the_category_is_not_found()
    {
        $this->withExceptionHandling();
        $this->get(route('categories.show', ['category' => 999]))
            ->assertStatus(404);
    }

    /** @test */
    public function it_loads_the_categories_details_page()
    {
        $category = Category::factory()->create();

        Article::factory()->times(3)->create(['category_id' => $category->id]);

        $this->get(route('categories.show', ['category' => $category->id]))
            ->assertOk()
            ->assertSeeInOrder([
                $category->name,
                $category->articles->count(),
                $category->description,
            ]);
    }
}
