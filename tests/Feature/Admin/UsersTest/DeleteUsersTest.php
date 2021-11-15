<?php

namespace Tests\Feature;

use App\Models\{Role, User, Nre};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteUsersTest extends TestCase
{
    use RefreshDatabase;

    function test_it_sends_a_user_to_the_trash()
    {
        $admin = User::factory()->create([
            'name' => 'User1',
            'nre_id' => Nre::factory()->create()->id,
        ]);

        $adminRole = Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator ', // optional
            'description' => 'User allowed to see the index of users', // optional
        ]);
        $admin->attachRole($adminRole);

        $user = User::factory()->create([
            'nre_id' => Nre::factory()->create()->id,
            'deleted_at' => null
        ]);

        $this->actingAs($admin)->patch("users/{$user->id}/papelera")
            ->assertRedirect('users');

        $user->refresh();
        $this->assertTrue($user->trashed());
    }

    function test_it_completely_deletes_a_user()
    {
        $admin = User::factory()->create([
            'name' => 'User1',
            'nre_id' => Nre::factory()->create()->id,
        ]);

        $adminRole = Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator ', // optional
            'description' => 'User allowed to see the index of users', // optional
        ]);
        $admin->attachRole($adminRole);

        $user = User::factory()->create([
            'nre_id' => Nre::factory()->create()->id,
            'deleted_at' => now()
        ]);

        $this->actingAs($admin)->delete("/users/delete/{$user->id}")
            ->assertRedirect('users/papelera');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    function test_it_cannot_delete_a_user_that_is_not_in_the_trash()
    {
        $this->withExceptionHandling();

        $admin = User::factory()->create([
            'name' => 'User1',
            'nre_id' => Nre::factory()->create()->id,
        ]);

        $adminRole = Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator ', // optional
            'description' => 'User allowed to see the index of users', // optional
        ]);
        $admin->attachRole($adminRole);

        $user = User::factory()->create([
            'nre_id' => Nre::factory()->create()->id,
            'deleted_at' => null
        ]);

        $this->actingAs($admin)->delete("/users/delete/{$user->id}")
            ->assertStatus(404);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
    }

    function test_it_completely_restores_a_user()
    {
        $this->withExceptionHandling();

        $admin = User::factory()->create([
            'name' => 'User1',
            'nre_id' => Nre::factory()->create()->id,
        ]);

        $adminRole = Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator ', // optional
            'description' => 'User allowed to see the index of users', // optional
        ]);
        $admin->attachRole($adminRole);

        $user = User::factory()->create([
            'nre_id' => Nre::factory()->create()->id,
            'deleted_at' => now()
        ]);

        $this->actingAs($admin)->put("/users/{$user->id}/papelera")
            ->assertRedirect('users/papelera');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
    }
}
