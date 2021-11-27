<?php

namespace Tests\Feature\Admin\CategoriesTest;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'category_name' => "Bebidas",
        'category_description' => "Categoría de bebidas",
    ];

    /** @test  */
    public function it_shows_the_create_category_page()
    {
        $this->actingAs($this->getAdmin())->get(route('categories.create'))
            ->assertStatus(200)
            ->assertSee('Nueva categoría');
    }

    /** @test  */
    public function it_creates_a_new_category()
    {
        $file = UploadedFile::fake()->image('image.jpg', 100, 100);


        $this->actingAs($this->getAdmin())->from(route('categories.create'))
            ->post(route('categories.store'),  $this->withData([
                'category_image' => $file
            ]))->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Bebidas',
            'description' => 'Categoría de bebidas',
            'image' => substr(time(), 0, -1).'-bebidas.jpg'
        ]);
        $category = Category::first();

        $this->assertTrue(file_exists( storage_path() . '/app/public/img/categories/' .$category->image));
        $this->assertTrue( getimagesize(storage_path() . '/app/public/img/categories/' .$category->image)[0] == 1024);
        unlink(storage_path().'/app/public/img/categories/' .$category->image);

    }

    /** @test  */
    public function the_category_image_field_is_nullable()
    {
        $this->actingAs($this->getAdmin())->from(route('categories.create'))
            ->post(route('categories.store'), $this->withData([
                'category_image' => null
            ]))->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'image' => null,
        ]);
    }

    /** @test  */
    public function the_category_image_must_be_an_image()
    {
        $image = UploadedFile::fake()->create('image.pdf', 1000);
        $this->assertFieldToFail('category_image', $image);
    }

    /** @test  */
    public function the_category_image_mimes_must_be_valid()
    {
        $imageGIF =  UploadedFile::fake()->image('image.gif', 100, 100);
        $imageSVG =  UploadedFile::fake()->image('image.svg', 100, 100);
        $this->assertFieldToFail('category_image', $imageGIF);
        $this->assertFieldToFail('category_image', $imageSVG);
    }


    /** @test  */
    public function the_category_description_field_is_nullable()
    {
        $this->actingAs($this->getAdmin())->from(route('categories.create'))
            ->post(route('categories.store'), $this->withData([
                'category_description' => null
            ]))->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => "Bebidas",
            'description' => null,
        ]);
    }

    /** @test  */
    public function the_category_name_field_must_be_valid()
    {
        $this->assertFieldToFail('category_name', "B3B1DAS123");
    }

    /** @test  */
    public function the_category_name_field_is_required()
    {
        $this->isRequiredField('category_name');
    }

    /** @test  */
    public function the_category_name_field_its_in_ranges()
    {
        $this->itsInRanges('category_name',2,21);
    }

    /** @test  */
    public function the_category_description_field_its_in_ranges()
    {
        $this->itsInRanges('category_description',9,2001);
    }

    /** @test  */
    public function the_category_name_must_be_unique()
    {
        $this->handleValidationExceptions();

        Category::factory()->create(['name' => 'Snacks']);

        $this->actingAs($this->getAdmin())->from(route('categories.create'))
            ->post(route('categories.store'), $this->withData([
                'category_name' => 'Snacks'
            ]))->assertSessionHasErrors('category_name')
            ->assertRedirect(url()->previous());

        $this->assertDatabaseCount('categories', 1);
    }

    public function itsInRanges($field, $min, $max)
    {
        $this->assertFieldToFail($field, $min);
        $this->assertFieldToFail($field, $max);
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

        $this->actingAs($this->getAdmin())->from(route('categories.create'))
            ->post(route('categories.store'), $this->withData([
                $field => $value
            ]))->assertSessionHasErrors([$field])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('categories');
    }
}
