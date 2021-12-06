<?php

namespace Tests\Feature\Admin\ShopTest;

use App\Http\Livewire\ShopProdcuts;
use App\Models\Article;
use App\Models\Category;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_a_404_error_if_the_shop_article_is_not_found()
    {
        $this->withExceptionHandling();
        $this->get(route('shop.show', ['article' => 999]))
            ->assertStatus(404);
    }

    /** @test */
    public function it_loads_the_shop_articles_details_page()
    {
        $article = $this->createAnArticle();

        $this->get(route('shop.show', ['article' => $article->id]))
            ->assertOk()
            ->assertSeeInOrder([
                'Pizza',
                'Snacks',
                '1.75',
                '156.6',
                '2.5',
                '300.27',
                'Harina de trigo',
                'No apto para celiacos'
            ])->assertDontSee('111');

    }

    /** @test */
    public function it_loads_the_shop_articles_details_page_from_livewire_component(){
        $article = $this->createAnArticle();

        Livewire::test(ShopProdcuts::class)
            ->call('openProductModal', $article->id)
            ->assertSeeInOrder([
                'Pizza',
                'Snacks',
                '1.75',
                '156.6',
                '2.5',
                '300.27',
                'Harina de trigo',
                'No apto para celiacos'
            ])
            ->assertDontSee(['111']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private function createAnArticle()
    {
        $category = Category::factory()->create(['name' => 'Snacks']);
        $article = Article::factory()->create([
            'category_id' => $category->id,
            'name' => "Pizza",
            'stock' => 111,
            'price' => 1.75,
            'discounted_price' => 1.75,
            'discount' => 0,
        ]);

        $article->nutrition()->update([
            'is_allergy' => true,
            'calories' => 300.27,
            'sodium' => 2.5,
            'proteins' => 156.6,
            'ingredients_description' => "Harina de trigo",
            'allergy_description' => "No apto para celiacos"
        ]);
        return $article;
    }
}
