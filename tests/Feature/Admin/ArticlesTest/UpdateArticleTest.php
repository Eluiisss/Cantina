<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateArticleTest extends TestCase
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
    public function it_shows_the_edit_article_page()
    {
          $category = Category::factory()->create(['name' => 'Comida']);
          $article = Article::factory()->create([
                'category_id' => $category->id
            ]);

        $this->actingAs($this->getAdmin())->get(route('articles.edit', ['article' => $article]))
            ->assertStatus(200)
            ->assertSee('Editar prodcuto')
            ->assertViewCollection('categories')
            ->contains($category);
    }

    /** @test */
    function an_article_can_be_updated()
    {
        $oldCategory = Category::factory()->create();
        $article = Article::factory()->create([
            'name' => 'Croissant',
            'stock' => 20,
            'price' => 3.75,
            'category_id' => $oldCategory->id,
            'image' => 'croissant.jpg'
        ]);

        $article->nutrition()->update([
            'calories' => 500,
            'sodium' =>  3,
            'proteins' => 250.52,
            'ingredients_description' => "Ingredientes de Croissant Harina, Edulcorante",
        ]);
        $this->assertDatabaseHas('articles', [
            'name' => 'Croissant',
            'stock' => 20,
            'price' => 3.75,
            'image' => 'croissant.jpg'
        ]);

        $this->assertDatabaseHas('nutrition', [
            'calories' => 500,
            'sodium' =>  3,
            'proteins' => 250.52,
            'ingredients_description' => "Ingredientes de Croissant Harina, Edulcorante",
        ]);

        $category = Category::factory()->create(['name' => 'Comida']);
        $file = UploadedFile::fake()->image('image.jpg', 100, 100);

        $this->actingAs($this->getAdmin())->from(route('articles.edit', ['article' => $article]))
            ->put(route('articles.update', ['article' => $article]), $this->withData([
                'article_category' => $category->id,
                'article_image' => $file
            ]))->assertRedirect(route('articles.show', ['article' => $article]));

        $this->assertDatabaseHas('articles', [
            'name' => 'Pizza',
            'stock' => 12,
            'price' => 1.75,
            'discount' => 0,
            'image' => substr(time(), 0, -1).'-pizza.jpg'
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

        $article = Article::query()->whereName('Pizza')->first();

        $this->assertTrue(file_exists( storage_path() . '/app/public/img/articles/' .$article->image));
        $this->assertTrue( getimagesize(storage_path() . '/app/public/img/articles/' .$article->image)[0] == 1024);
        unlink(storage_path().'/app/public/img/articles/' .$article->image);
    }

    /** @test  */
    public function the_article_image_field_is_nullable_after_updating()
    {
        $this->handleValidationExceptions();

        $oldCategory = Category::factory()->create();
        $article = Article::factory()->create([
            'category_id' => $oldCategory->id,
            'image' => 'croissant.jpg'
        ]);
        $this->actingAs($this->getAdmin())->from(route('articles.edit', ['article' => $article]))
            ->put(route('articles.update', ['article' => $article]), $this->withData([
                'article_category' => $oldCategory->id,
                'article_image' => null
            ]))->assertRedirect(route('articles.show', ['article' => $article]));

        $this->assertDatabaseHas('articles', [
            'image' => 'croissant.jpg'
        ]);
    }

    /** @test  */
    public function the_article_image_must_be_an_image_after_updating()
    {
        $image = UploadedFile::fake()->create('image.pdf', 1000);
        $this->assertFieldToFail('article_image', $image);
    }

    /** @test  */
    public function the_article_image_mimes_must_be_valid_after_updating()
    {
        $imageGIF =  UploadedFile::fake()->image('image.gif', 100, 100);
        $imageSVG =  UploadedFile::fake()->image('image.svg', 100, 100);
        $this->assertFieldToFail('article_image', $imageGIF);
        $this->assertFieldToFail('article_image', $imageSVG);
    }

    /** @test  */
    public function the_allergy_description_is_required_when_allergy_field_is_true_after_updating()
    {
        $this->handleValidationExceptions();

        $oldCategory = Category::factory()->create();
        $article = Article::factory()->create([
            'category_id' => $oldCategory->id
        ]);

        $this->actingAs($this->getAdmin())->from(route('articles.edit', ['article' => $article]))
            ->put(route('articles.update', ['article' => $article]), $this->withData([
                'article_allergy' => 1,
                'article_allergy_description' => null
            ]))->assertSessionHasErrors(['article_allergy_description'])
            ->assertRedirect(route('articles.edit', ['article' => $article]));

    }

    /** @test  */
    public function the_allergy_description_is_nullable_when_allergy_field_is_false_after_updating()
    {
        $this->handleValidationExceptions();

        $oldCategory = Category::factory()->create();
        $article = Article::factory()->create([
            'category_id' => $oldCategory->id
        ]);

        $this->actingAs($this->getAdmin())->from(route('articles.edit', ['article' => $article]))
            ->put(route('articles.update', ['article' => $article]), $this->withData([
                'article_allergy' => 0,
                'article_allergy_description' => null,
                'article_category' => $oldCategory->id
            ]))->assertRedirect(route('articles.show', ['article' => $article]));


        $this->assertDatabaseHas('nutrition', [
            'is_allergy' => 0,
            'allergy_description' => null,
        ]);
    }

    /** @test  */
    public function the_name_format_must_be_valid_after_updating()
    {
        $this->assertFieldToFail('article_name', "Coc4C0l@");
    }

    /** @test  */
    public function the_category_must_be_valid_after_updating()
    {
        $category = Category::factory()->create(['name' => 'Bebida']);
        $this->assertFieldToFail('article_category', $category->id+999);
    }

    /** @test  */
    public function the_name_is_required_after_updating()
    {
        $this->isRequiredField('article_name');
    }

    /** @test  */
    public function the_category_is_required_after_updating()
    {
        $this->isRequiredField('article_category');
    }

    /** @test  */
    public function the_price_is_required_after_updating()
    {
        $this->isRequiredField('article_price');
    }

    /** @test  */
    public function the_stock_is_required_after_updating()
    {
        $this->isRequiredField('article_stock');
    }

    /** @test  */
    public function the_discount_is_required_after_updating()
    {
        $this->isRequiredField('article_discount');
    }

    /** @test  */
    public function the_calories_is_required_after_updating()
    {
        $this->isRequiredField('article_calories');
    }

    /** @test  */
    public function the_sodium_is_required_after_updating()
    {
        $this->isRequiredField('article_sodium');
    }

    /** @test  */
    public function the_proteins_is_required_after_updating()
    {
        $this->isRequiredField('article_proteins');
    }

    /** @test  */
    public function the_veg_is_required_after_updating()
    {
        $this->isRequiredField('article_veg');
    }

    /** @test  */
    public function the_allergy_is_required_after_updating()
    {
        $this->isRequiredField('article_allergy');
    }

    /** @test  */
    public function the_ingredients_description_is_required_after_updating()
    {
        $this->isRequiredField('article_ingredients_description');
    }

    /** @test  */
    public function the_price_must_be_numeric_after_updating()
    {
        $this->isNumericField('article_price');
    }

    /** @test  */
    public function the_stock_must_be_numeric_after_updating()
    {
        $this->isNumericField('article_stock');
    }

    /** @test  */
    public function the_discount_must_be_numeric_after_updating()
    {
        $this->isNumericField('article_discount');
    }

    /** @test  */
    public function the_calories_must_be_numeric_after_updating()
    {
        $this->isNumericField('article_calories');
    }

    /** @test  */
    public function the_sodium_must_be_numeric_after_updating()
    {
        $this->isNumericField('article_sodium');
    }

    /** @test  */
    public function the_proteins_must_be_numeric_after_updating()
    {
        $this->isNumericField('article_proteins');
    }

    /** @test  */
    public function the_name_range_must_be_valid_after_updating()
    {
        $this->itsInRanges('article_name',0,30);
    }

    /** @test  */
    public function the_price_range_must_be_valid_after_updating()
    {
        $this->itsInRanges('article_price',-1,10001);
    }

    /** @test  */
    public function the_stock_range_must_be_valid_after_updating()
    {
        $this->itsInRanges('article_stock',-1,1001);
    }

    /** @test  */
    public function the_discount_range_must_be_valid_after_updating()
    {
        $this->itsInRanges('article_discount',-1,101);
    }

    /** @test  */
    public function the_calories_range_must_be_valid_after_updating()
    {
        $this->itsInRanges('article_calories',-1,5001);
    }

    /** @test  */
    public function the_sodium_range_must_be_valid_after_updating()
    {
        $this->itsInRanges('article_sodium',-1,501);
    }

    /** @test  */
    public function the_proteins_range_must_be_valid_after_updating()
    {
        $this->itsInRanges('article_proteins',-1,201);
    }

    /** @test  */
    public function the_ingredients_description_range_must_be_valid_after_updating()
    {
        $this->itsInRanges('article_ingredients_description',0,3001);
    }

    /** @test  */
    public function the_allergy_description_range_must_be_valid_after_updating()
    {
        $this->itsInRanges('article_allergy_description',0,3001);
    }

    /** @test  */
    public function the_veg_must_be_a_boolean_after_updating()
    {
        $this->isBoolField('article_veg');
    }

    /** @test  */
    public function the_allergy_must_be_a_boolean_after_updating()
    {
        $this->isBoolField('article_allergy');
    }

    ///
    public function isRequiredField($field): void
    {
        $this->assertFieldToFail($field);
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

    /**
     * @param $field
     * @param $value
     */
    private function assertFieldToFail($field, $value=null): void
    {
        $this->handleValidationExceptions();
        $this->withExceptionHandling();

        $category = Category::factory()->create();
        $article = Article::factory()->create([
            'category_id' => $category->id
        ]);

        $this->actingAs($this->getAdmin())->from(route('articles.edit', ['article' => $article]))
            ->put(route('articles.update', ['article' => $article]), $this->withData([
                $field => $value
            ]))->assertSessionHasErrors([$field])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('articles', [
            'name' => $article->name,
            'category_id' => $category->id,
            'stock' => $article->stock,
            'price' =>  $article->price,
            'discount' => $article->discount,
        ]);

        $this->assertDatabaseHas('nutrition', [
            'article_id' => $article->id,
            'is_veg' => $article->nutrition->is_veg,
            'is_allergy' => $article->nutrition->is_allergy,
            'calories' => $article->nutrition->calories,
            'sodium' => $article->nutrition->sodium,
            'proteins' => $article->nutrition->proteins,
            'ingredients_description' => $article->nutrition->ingredients_description,
            'allergy_description' => $article->nutrition->allergy_description,
        ]);
    }


}
