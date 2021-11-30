<?php

namespace Tests\Feature\Admin\ShopTest;

use App\Http\Livewire\ShopProdcuts;
use App\Models\Article;
use App\Models\Category;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterShopProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_shop_page_with_filters()
    {
        $this->actingAs($this->getAdmin());

        $category = Category::factory()->create();
        Article::factory()->create(['category_id' => $category->id]);

        $this->get(route('shop.index'))
            ->assertStatus(200)
            ->assertSee(trans('shop.products.vegetarian'))
            ->assertSee(trans('shop.products.allegy'));

        Livewire::test(ShopProdcuts::class)->assertViewHas('categories', function ($categories) use ($category){
            return  (true == $categories->contains($category));
        });
    }

    /** @test */
    public function it_filter_the_shop_articles_by_category_field()
    {
        $this->actingAs($this->getAdmin());

        $bebida = Category::factory()->create(['name' => 'Bebidas']);
        $snack = Category::factory()->create(['name' => 'Snacks']);
        $agua = Article::factory()->create(['category_id' => $bebida->id]);
        $pizza = Article::factory()->create(['category_id' => $snack->id]);

        Livewire::test(ShopProdcuts::class)->set('category', 'Bebidas')->assertViewHas('articles', function ($articles) use ($agua, $pizza){
            return  (true == $articles->contains($agua))
                && (false == $articles->contains($pizza));
        });

        Livewire::test(ShopProdcuts::class)->set('category', 'Snacks')->assertViewHas('articles', function ($articles) use ($agua, $pizza){
            return  (true == $articles->contains($pizza))
                && (false == $articles->contains($agua));
        });

    }

    /** @test */
    public function it_filter_the_shop_articles_by_vegetarian_articles_only(){
        $this->actingAs($this->getAdmin());

        $category = Category::factory()->create();
        $veg = Article::factory()->create(['category_id' => $category->id]);
        $nonVeg = Article::factory()->create(['category_id' => $category->id]);

        $veg->nutrition()->update([
            'is_veg' => true,
        ]);

        $nonVeg->nutrition()->update([
            'is_veg' => false,
        ]);

        Livewire::test(ShopProdcuts::class)->set('veg', true)->assertViewHas('articles', function ($articles) use ($veg, $nonVeg){
            return  (true == $articles->contains($veg))
                && (false == $articles->contains($nonVeg));
        });

        Livewire::test(ShopProdcuts::class)->set('veg', false)->assertViewHas('articles', function ($articles) use ($veg, $nonVeg){
            return  (true == $articles->contains($veg))
                && (true == $articles->contains($nonVeg));
        });

    }

    /** @test */
    public function it_filter_the_shop_articles_by_non_allergy_articles_only(){
        $this->actingAs($this->getAdmin());

        $category = Category::factory()->create();
        $allergy = Article::factory()->create(['category_id' => $category->id]);
        $nonAllergy = Article::factory()->create(['category_id' => $category->id]);

        $allergy->nutrition()->update([
            'is_allergy' => true,
        ]);

        $nonAllergy->nutrition()->update([
            'is_allergy' => false,
        ]);

        Livewire::test(ShopProdcuts::class)->set('allergy', true)->assertViewHas('articles', function ($articles) use ($allergy, $nonAllergy){
            return  (true == $articles->contains($nonAllergy))
                && (false == $articles->contains($allergy));
        });

        Livewire::test(ShopProdcuts::class)->set('allergy', false)->assertViewHas('articles', function ($articles) use ($allergy, $nonAllergy){
            return  (true == $articles->contains($nonAllergy))
                && (true == $articles->contains($allergy));
        });
    }
}
