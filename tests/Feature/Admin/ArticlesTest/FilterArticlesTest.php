<?php

namespace Tests\Feature\Admin\ArticlesTest;

use App\Models\Article;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterArticlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_article_list_page_with_filters()
    {
        $category = Category::factory()->create();
        Article::factory()->create(['category_id' => $category->id]);

        $response = $this->get(route('articles.index'))
            ->assertStatus(200)
            ->assertSee(trans('articles.filters.allergy'))
            ->assertSee(trans('articles.filters.veg'))
            ->assertSee(trans('articles.filters.stock'));

        $response->assertViewHas('categories', function ($categories) use ($category){
            return  (true == $categories->contains($category));
        });
        $response->assertViewCollection('categories')
        ->contains($category);
    }

    /** @test */
    public function it_filter_articles_by_category_field()
    {
        $bebida = Category::factory()->create(['name' => 'Bebidas']);
        $snack = Category::factory()->create(['name' => 'Snacks']);
        $agua = Article::factory()->create(['category_id' => $bebida->id]);
        $pizza= Article::factory()->create(['category_id' => $snack->id]);

        $this->get(route('articles.index', ['category' => 'Bebidas']))
            ->assertViewCollection('articles')
            ->contains($agua)
            ->notContains($pizza);

        $this->get(route('articles.index', ['category' => 'Snacks']))
            ->assertViewCollection('articles')
            ->contains($pizza)
            ->notContains($agua);
    }

    /** @test */
    public function it_can_filter_articles_by_category_when_article_is_trashed()
    {
        $bebida = Category::factory()->create(['name' => 'Bebidas']);
        $snack = Category::factory()->create(['name' => 'Snacks']);
        $agua = Article::factory()->create(['category_id' => $bebida->id]);
        $pizza= Article::factory()->create(['category_id' => $snack->id]);

        $agua->nutrition()->delete();
        $agua->delete();

        $pizza->nutrition()->delete();
        $pizza->delete();

        $this->get(route('articles.trashed', ['category' => 'Bebidas']))
            ->assertViewCollection('articles')
            ->contains($agua)
            ->notContains($pizza);

        $this->get(route('articles.trashed', ['category' => 'Snacks']))
            ->assertViewCollection('articles')
            ->contains($pizza)
            ->notContains($agua);
    }

    /** @test */
    public function it_filter_articles_by_stock_field()
    {
        $category = Category::factory()->create();
        $withStock = Article::factory()->create(['category_id' => $category->id, 'stock' => 10]);
        $withoutStock= Article::factory()->create(['category_id' => $category->id, 'stock' => 0]);

        $this->get(route('articles.index', ['stock' => 'with']))
            ->assertViewCollection('articles')
            ->contains($withStock)
            ->notContains($withoutStock);

        $this->get(route('articles.index', ['stock' => 'without']))
            ->assertViewCollection('articles')
            ->contains($withoutStock)
            ->notContains($withStock);
    }

    /** @test */
    public function it_filter_articles_by_allergy_field()
    {
        $category = Category::factory()->create();

        $allergy = Article::factory()->create(['category_id' => $category->id]);
        $nonAllergy = Article::factory()->create(['category_id' => $category->id]);

        $allergy->nutrition()->update([
            'is_allergy' => true,
        ]);

        $nonAllergy->nutrition()->update([
            'is_allergy' => false,
        ]);

        $this->get(route('articles.index', ['allergy' => 'nonallergy']))
            ->assertViewCollection('articles')
            ->contains($nonAllergy)
            ->notContains($allergy);

        $this->get(route('articles.index', ['allergy' => 'allergy']))
            ->assertViewCollection('articles')
            ->contains($allergy)
            ->notContains($nonAllergy);
    }

    /** @test */
    public function it_filter_articles_by_veg_field()
    {
        $category = Category::factory()->create();

        $veg = Article::factory()->create(['category_id' => $category->id]);
        $nonVeg = Article::factory()->create(['category_id' => $category->id]);

        $veg->nutrition()->update([
            'is_veg' => true,
        ]);

        $nonVeg->nutrition()->update([
            'is_veg' => false,
        ]);

        $this->get(route('articles.index', ['veg' => 'veg']))
            ->assertViewCollection('articles')
            ->contains($veg)
            ->notContains($nonVeg);

        $this->get(route('articles.index', ['veg' => 'nonveg']))
            ->assertViewCollection('articles')
            ->contains($nonVeg)
            ->notContains($veg);
    }
}
