<?php

namespace Tests\Feature\Admin\CategoriesTest;

use App\Models\Category;
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
        $this->get(route('categories.create'))
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
        ]);

        $this->from(route('categories.edit', ['category' => $oldCategory]))
            ->put(route('categories.update', ['category' => $oldCategory]), $this->withData())
            ->assertRedirect(route('categories.show', ['category' => $oldCategory]));

        $this->assertDatabaseHas('categories', [
            'name' => "Bebidas",
            'description' => "Categoría de bebidas",
        ]);
    }

    /** @test  */
    public function the_category_description_field_can_be_nullable_after_updating()
    {
        $category = Category::factory()->create();

        $this->from(route('categories.edit', ['category' => $category]))
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

        $this->from(route('categories.edit', ['category' => $oldCategory]))
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

        $this->from(route('categories.edit', ['category' => $category]))
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
