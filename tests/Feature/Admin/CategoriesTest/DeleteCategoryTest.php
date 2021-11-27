<?php

namespace Tests\Feature\Admin\CategoriesTest;

use App\Models\Article;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_deletes_a_category()
    {
        $category = Category::factory()->create();
        $response = $this->actingAs($this->getAdmin())->delete(route('categories.destroy', ['id' => $category->id]));
        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseEmpty('categories');
    }

    /** @test */
    function a_category_with_articles_associated_cannot_be_deleted()
    {
        $this->withExceptionHandling();

        $category = Category::factory()->create();
        Article::factory()->times(3)->create(['category_id' => $category->id]);

        $response = $this->actingAs($this->getAdmin())->delete(route('categories.destroy', ['id' => $category->id]));
        $response->assertStatus(400);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
        ]);
    }
}
