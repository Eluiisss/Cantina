<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestoreTeamTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_restore_a_trashed_article_and_his_nutrition()
    {
        $category = Category::factory()->create(['name' => 'Comida']);

        $article = Article::factory()->create([
            'category_id' => $category->id,
            'deleted_at'=> now(),
        ]);

        $this->get(route('articles.restore', ['id' => $article->id]))
            ->assertRedirect(route('articles.index'));

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
        ]);

        $this->assertDatabaseHas('nutrition', [
            'article_id' => $article->id,
        ]);
    }

}
