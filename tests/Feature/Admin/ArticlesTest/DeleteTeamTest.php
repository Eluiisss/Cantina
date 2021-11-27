<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTeamTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_sends_a_article_to_the_trash()
    {
        $category = Category::factory()->create(['name' => 'Comida']);

        $article = Article::factory()->create([
            'category_id' => $category->id
        ]);

        $articleTrashed = Article::factory()->create([
            'category_id' => $category->id
        ]);

        $this->actingAs($this->getAdmin())->patch(route('articles.trash', ['article' => $articleTrashed]))
        ->assertRedirect(route('articles.index'));

        $this->assertSoftDeleted('articles',[
            'id' => $articleTrashed->id,
        ]);

        $this->assertSoftDeleted('nutrition',[
            'article_id' => $articleTrashed->id,
        ]);

        $this->actingAs($this->getAdmin())->get(route('articles.index'))
            ->assertOk()
            ->assertSee($article->name)
            ->assertDontSee($articleTrashed->name)
            ->assertViewCollection('articles')
            ->contains($article)
            ->notContains($articleTrashed);

        $this->get(route('articles.trashed'))
            ->assertOk()
            ->assertViewCollection('articles')
            ->contains($articleTrashed)
            ->notContains($article);

    }

    /** @test */
    function it_completely_deletes_a_article()
    {
        $category = Category::factory()->create(['name' => 'Comida']);

        $article = Article::factory()->create([
            'category_id' => $category->id,
            'deleted_at'=> now(),
        ]);

        $this->actingAs($this->getAdmin())->delete(route('articles.destroy', ['id' => $article->id]))
            ->assertRedirect(route('articles.trashed'));

        $this->assertDatabaseEmpty('articles');
        $this->assertDatabaseEmpty('nutrition');
    }

    /** @test */
    function it_cannot_delete_a_article_that_is_not_in_the_trash()
    {
        $this->withExceptionHandling();

        $category = Category::factory()->create(['name' => 'Comida']);

        $articleNotTrashed = Article::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->actingAs($this->getAdmin())->delete(route('articles.destroy', ['id' => $articleNotTrashed->id]))->assertStatus(404);

        $this->assertDatabaseHas('articles', [
            'id' => $articleNotTrashed->id,
            'deleted_at' => null,
        ]);

        $this->assertDatabaseHas('nutrition', [
            'article_id' => $articleNotTrashed->id,
            'deleted_at' => null,
        ]);
    }
}
