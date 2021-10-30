<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'article_name' => "Pizza",
        'article_stock' => 12,
        'article_price' => 1.75,
        'article_discount' => 0,
        'article_veg' => false,
        'article_allergy' => false,
        'article_calories' => 300.30,
        'article_sodium' =>  2.50,
        'article_proteins' => 150.52,
        'article_ingredients_description' => "Ingredientes de pizza Harina, Jamón",
        'article_allergy_description' => "",
    ];

    /** @test  */
    public function it_shows_the_create_article_page()
    {
        $category = Category::factory()->create(['name' => 'Comida']);

        $this->get(route('articles.create'))
            ->assertStatus(200)
            ->assertSee('Nuevos productos')
            ->assertViewCollection('categories')
            ->contains($category);
    }

    /** @test  */
    public function it_creates_a_new_article()
    {
        $category = Category::factory()->create(['name' => 'Comida']);

         $this->from(route('articles.create'))
            ->post(route('articles.store', $this->withData([
                'article_category' => $category->id
            ])))->assertRedirect(route('articles.index'));

         $article = Article::query()->whereName('Pizza')->first();

        $this->assertDatabaseHas('articles', [
            'name' => 'Pizza',
            'stock' => 12,
            'price' => 1.75,
            'discount' => 0,
        ]);

        $this->assertDatabaseHas('nutrition', [
            'article_id' => $article->id,
            'is_veg' => 0,
            'is_allergy' => 0,
            'calories' => 300.30,
            'sodium' =>  2.50,
            'proteins' => 150.52,
            'ingredients_description' => "Ingredientes de pizza Harina, Jamón",
            'allergy_description' => null,
        ]);
    }

    /** @test  */
    public function the_allergy_description_is_required_when_allergy_field_is_true()
    {
        $this->handleValidationExceptions();

        $this->from(route('articles.create'))
            ->post(route('articles.store', $this->withData([
                'article_allergy' => true,
                'article_allergy_description' => null
            ])))->assertSessionHasErrors(['article_allergy_description'])
                ->assertRedirect(route('articles.create'));
    }

    /** @test  */
    public function the_allergy_description_is_nullable_when_allergy_field_is_false()
    {
        $category = Category::factory()->create(['name' => 'Comida']);

        $this->from(route('articles.create'))
            ->post(route('articles.store', $this->withData([
                'article_category' => $category->id,
                'article_allergy' => false,
                'article_allergy_description' => null
            ])))->assertRedirect(route('articles.index'));

        $this->assertDatabaseHas('nutrition', [
            'is_allergy' => 0,
            'allergy_description' => null,
        ]);
    }

    /** @test  */
    public function the_name_format_must_be_valid()
    {
        $this->assertFieldToFail('article_name', "Coc4C0l@");
    }

    /** @test  */
    public function the_category_must_be_valid()
    {
        $category = Category::factory()->create(['name' => 'Comida']);
        $this->assertFieldToFail('article_category', $category->id+999);
    }

    /** @test  */
    public function the_name_is_required()
    {
        $this->isRequiredField('article_name');
    }

    /** @test  */
    public function the_category_is_required()
    {
        $this->isRequiredField('article_category');
    }

    /** @test  */
    public function the_price_is_required()
    {
        $this->isRequiredField('article_price');
    }

    /** @test  */
    public function the_stock_is_required()
    {
        $this->isRequiredField('article_stock');
    }

    /** @test  */
    public function the_discount_is_required()
    {
        $this->isRequiredField('article_discount');
    }

    /** @test  */
    public function the_calories_is_required()
    {
        $this->isRequiredField('article_calories');
    }

    /** @test  */
    public function the_sodium_is_required()
    {
        $this->isRequiredField('article_sodium');
    }

    /** @test  */
    public function the_proteins_is_required()
    {
        $this->isRequiredField('article_proteins');
    }

    /** @test  */
    public function the_veg_is_required()
    {
        $this->isRequiredField('article_veg');
    }

    /** @test  */
    public function the_allergy_is_required()
    {
        $this->isRequiredField('article_allergy');
    }

    /** @test  */
    public function the_ingredients_description_is_required()
    {
        $this->isRequiredField('article_ingredients_description');
    }

    /** @test  */
    public function the_price_must_be_numeric()
    {
        $this->isNumericField('article_price');
    }

    /** @test  */
    public function the_stock_must_be_numeric()
    {
        $this->isNumericField('article_stock');
    }

    /** @test  */
    public function the_discount_must_be_numeric()
    {
        $this->isNumericField('article_discount');
    }

    /** @test  */
    public function the_calories_must_be_numeric()
    {
        $this->isNumericField('article_calories');
    }

    /** @test  */
    public function the_sodium_must_be_numeric()
    {
        $this->isNumericField('article_sodium');
    }

    /** @test  */
    public function the_proteins_must_be_numeric()
    {
        $this->isNumericField('article_proteins');
    }

    /** @test  */
    public function the_name_range_must_be_valid()
    {
        $this->itsInRanges('article_name',0,30);
    }

    /** @test  */
    public function the_price_range_must_be_valid()
    {
        $this->itsInRanges('article_price',-1,10001);
    }

    /** @test  */
    public function the_stock_range_must_be_valid()
    {
        $this->itsInRanges('article_stock',-1,1001);
    }

    /** @test  */
    public function the_discount_range_must_be_valid()
    {
        $this->itsInRanges('article_discount',-1,101);
    }

    /** @test  */
    public function the_calories_range_must_be_valid()
    {
        $this->itsInRanges('article_calories',-1,5001);
    }

    /** @test  */
    public function the_sodium_range_must_be_valid()
    {
        $this->itsInRanges('article_sodium',-1,501);
    }

    /** @test  */
    public function the_proteins_range_must_be_valid()
    {
        $this->itsInRanges('article_proteins',-1,201);
    }

    /** @test  */
    public function the_ingredients_description_range_must_be_valid()
    {
        $this->itsInRanges('article_ingredients_description',0,3001);
    }

    /** @test  */
    public function the_allergy_description_range_must_be_valid()
    {
        $this->itsInRanges('article_allergy_description',0,3001);
    }

    /** @test  */
    public function the_veg_must_be_a_boolean()
    {
        $this->isBoolField('article_veg');
    }

    /** @test  */
    public function the_allergy_must_be_a_boolean()
    {
        $this->isBoolField('article_allergy');
    }

    public function itsInRanges($field, $min, $max)
    {
        $this->assertFieldToFail($field, $min);
        $this->assertFieldToFail($field, $max);
    }

    public function isBoolField($field): void
    {
        $this->assertFieldToFail($field, "True");
    }

    public function isNumericField($field): void
    {
        $this->assertFieldToFail($field, "ABC");
    }

    public function isRequiredField($field): void
    {
        $this->assertFieldToFail($field);
    }

    /**
     * @param $field
     * @param $value
     */
    private function assertFieldToFail($field, $value=null): void
    {
        $this->handleValidationExceptions();

        $this->from(route('articles.create'))
            ->post(route('articles.store'), $this->withData([
                $field => $value
            ]))->assertSessionHasErrors([$field])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('articles');
        $this->assertDatabaseEmpty('nutrition');
    }
}
