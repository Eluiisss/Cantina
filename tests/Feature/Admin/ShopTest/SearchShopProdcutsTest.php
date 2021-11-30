<?php

namespace Tests\Feature\Admin\ShopTest;

use App\Http\Livewire\ShopProdcuts;
use App\Models\Article;
use App\Models\Category;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchShopProdcutsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function search_shop_articles_by_name(){
        $this->actingAs($this->getAdmin());

        $category = Category::factory()->create();
        $agua = Article::factory()->create(['category_id' => $category->id, 'name' => 'Agua']);
        $pizza = Article::factory()->create(['category_id' => $category->id, 'name' => 'Pizza']);

        Livewire::test(ShopProdcuts::class)->set('search', 'Pizza')->assertViewHas('articles', function ($articles) use ($agua, $pizza){
            return  (true == $articles->contains($pizza))
                && (false == $articles->contains($agua));
        });

        Livewire::test(ShopProdcuts::class)->set('search', 'Agu')->assertViewHas('articles', function ($articles) use ($agua, $pizza){
            return  (true == $articles->contains($agua))
                && (false == $articles->contains($pizza));
        });
    }

    /** @test */
    public function search_shop_articles_by_category_name(){
        $this->actingAs($this->getAdmin());

        $bebida = Category::factory()->create(['name' => 'Bebidas']);
        $snack = Category::factory()->create(['name' => 'Snacks']);
        $agua = Article::factory()->create(['category_id' => $bebida->id]);
        $pizza= Article::factory()->create(['category_id' => $snack->id]);

        Livewire::test(ShopProdcuts::class)->set('search', 'Bebidas')->assertViewHas('articles', function ($articles) use ($agua, $pizza){
            return  (true == $articles->contains($agua))
                && (false == $articles->contains($pizza));
        });

        Livewire::test(ShopProdcuts::class)->set('search', 'Snac')->assertViewHas('articles', function ($articles) use ($agua, $pizza){
            return  (true == $articles->contains($pizza))
                && (false == $articles->contains($agua));
        });

    }

    /** @test */
    public function search_shop_articles_by_allergy_description(){
        $this->actingAs($this->getAdmin());

        $category = Category::factory()->create();
        $gluten = Article::factory()->create(['category_id' => $category->id]);
        $avellanas = Article::factory()->create(['category_id' => $category->id]);

        $gluten->nutrition()->update([
            'is_allergy' => true,
            'allergy_description' => 'Gluten Voluptatibus fugiat in sint rem aut quos et sunt voluptates ad reiciendis.'
        ]);

        $avellanas->nutrition()->update([
            'is_allergy' => true,
            'allergy_description' => 'Avellanas Voluptatibus fugiat in sint rem aut quos et sunt voluptates ad reiciendis.'
        ]);

        Livewire::test(ShopProdcuts::class)->set('search', 'Avellanas')->assertViewHas('articles', function ($articles) use ($gluten, $avellanas){
            return  (true == $articles->contains($avellanas))
                && (false == $articles->contains($gluten));
        });

        Livewire::test(ShopProdcuts::class)->set('search', 'Glut')->assertViewHas('articles', function ($articles) use ($gluten, $avellanas){
            return  (true == $articles->contains($gluten))
                && (false == $articles->contains($avellanas));
        });

    }
}
