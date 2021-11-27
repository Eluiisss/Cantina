<?php

namespace Tests\Feature\Admin\CategoriesTest;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'category_name' => "Bebidas",
        'category_description' => "Categoría de bebidas",
    ];

    /** @test  */
    public function it_shows_the_edit_category_page()
    {
        $this->actingAs($this->getAdmin())->get(route('categories.create'))
            ->assertStatus(200)
            ->assertSee('Nueva categoría');
    }

    /** @test */
    function a_category_can_be_updated()
    {
        $oldCategory = Category::factory()->create();

        $this->assertDatabaseHas('categories', [
            'name' => $oldCategory->name,
            'description' => $oldCategory->description,
            'image' => $oldCategory->image,
        ]);
        $file = UploadedFile::fake()->image('image.jpg', 100, 100);

        $this->actingAs($this->getAdmin())->from(route('categories.edit', ['category' => $oldCategory]))
            ->put(route('categories.update', ['category' => $oldCategory]), $this->withData([
                'category_image' => $file
            ]))
            ->assertRedirect(route('categories.show', ['category' => $oldCategory]));

        $this->assertDatabaseHas('categories', [
            'name' => "Bebidas",
            'description' => "Categoría de bebidas",
            'image' => substr(time(), 0, -1).'-bebidas.jpg'
        ]);

        $category = Category::first();

        $this->assertTrue(file_exists( storage_path() . '/app/public/img/categories/' .$category->image));
        $this->assertTrue( getimagesize(storage_path() . '/app/public/img/categories/' .$category->image)[0] == 1024);
        unlink(storage_path().'/app/public/img/categories/' .$category->image);
    }

    /** @test  */
    public function the_category_image_field_can_be_nullable_after_updating()
    {
        $category = Category::factory()->create(['image' => 'cat-bebidas.jpg']);

        $this->actingAs($this->getAdmin())->from(route('categories.edit', ['category' => $category]))
            ->put(route('categories.update', ['category' => $category]), $this->withData([
                'category_image' => null,
            ]))->assertRedirect(route('categories.show', ['category' => $category]));

        $this->assertDatabaseHas('categories', [
            'image' => 'cat-bebidas.jpg',
        ]);
    }

    /** @test  */
    public function the_category_image_must_be_an_image_after_updating()
    {
        $image = UploadedFile::fake()->create('image.pdf', 1000);
        $this->assertFieldToFail('category_image', $image);
    }

    /** @test  */
    public function the_category_image_mimes_must_be_valid_after_updating()
    {
        $imageGIF =  UploadedFile::fake()->image('image.gif', 100, 100);
        $imageSVG =  UploadedFile::fake()->image('image.svg', 100, 100);
        $this->assertFieldToFail('category_image', $imageGIF);
        $this->assertFieldToFail('category_image', $imageSVG);
    }

    /** @test  */
    public function the_category_description_field_can_be_nullable_after_updating()
    {
        $category = Category::factory()->create();

        $this->actingAs($this->getAdmin())->from(route('categories.edit', ['category' => $category]))
            ->put(route('categories.update', ['category' => $category]), $this->withData([
                'category_description' => null,
            ]))->assertRedirect(route('categories.show', ['category' => $category]));

        $this->assertDatabaseHas('categories', [
            'description' => null,
        ]);
    }

    /** @test  */
    public function the_category_name_must_be_unique_after_updating()
    {
        $this->handleValidationExceptions();

        Category::factory()->create(['name' => 'Bebidas']);
        $oldCategory = Category::factory()->create(['name' => 'Snacks']);

        $this->actingAs($this->getAdmin())->from(route('categories.edit', ['category' => $oldCategory]))
            ->put(route('categories.update', ['category' => $oldCategory]), $this->withData([
                'category_name' => 'Bebidas',
            ]))->assertSessionHasErrors('category_name')
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('categories', [
            'name' => 'Bebidas',
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Snacks',
        ]);

        $this->assertDatabaseCount('categories', 2);

    }

    /** @test  */
    public function the_category_name_field_must_be_valid_after_updating()
    {
        $this->isRequiredField('category_name', "B3B1DAS123");
    }

    /** @test  */
    public function the_category_name_field_is_required_after_updating()
    {
        $this->isRequiredField('category_name');
    }

    /** @test  */
    public function the_category_name_field_its_in_ranges_after_updating()
    {
        $this->itsInRanges('category_name',2,21);
    }

    /** @test  */
    public function the_category_description_field_its_in_ranges_after_updating()
    {
        $this->itsInRanges('category_description',9,2001);
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

        $category = Category::factory()->create();

        $this->actingAs($this->getAdmin())->from(route('categories.edit', ['category' => $category]))
            ->put(route('categories.update', ['category' => $category]), $this->withData([
                $field => $value
            ]))->assertSessionHasErrors([$field])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('categories', [
            'name' => $category->name,
            'description' => $category->description,
        ]);
    }
}
