<?php

namespace Tests\Feature\Admin\UsersTest;

use App\Models\{User,Nre,Role};
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUsersTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'user_name' => 'defaultName',
        'user_phone' => '111111111',
        'user_email' => 'default@mail.es',
        'user_class' => '1ºDAW',
        'user_credit' => 10
    ];

    public function createRandomUser()
    {
        $userNre = Nre::factory()->create();
        $user = User::factory()->create([
            'nre_id' => $userNre->id,
        ]);

        $userNre->update([
            'user_id' => $user->id,
            'updated_at' => now(),
        ]);
        return $user;
    }

    /** @test  */
    public function it_shows_the_edit_user_page()
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

        $user = $this->createRandomUser();

        $this->actingAs($admin)->get(route('users.edit', ['user' => $user]))
            ->assertStatus(200)
            ->assertSee('Editar Usuario')
            ->assertSee($user->name);
    }

     /** @test  */
    function an_user_can_be_updated()
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

        $userNre = Nre::factory()->create();
        $oldUser = User::factory()->create([
            'nre_id' => $userNre->id,
            'name' => 'Usuario test',
            'phone' => '666666666',
            'email' =>'usertTest@mail.es',
            'class' => '2ºDAW',
        ]);

        $userNre->update([
            'user_id' => $oldUser->id,
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Usuario test',
            'phone' => '666666666',
            'email' =>'usertTest@mail.es',
            'class' => '2ºDAW',
        ]);

        $this->actingAs($admin)->from(route('users.edit', ['user' => $oldUser]))
            ->put(route('users.update', ['user' => $oldUser]), $this->withData([
                'user_phone' => '777777777',
                'user_email' =>'newusertTest@mail.es',
                'user_class' => '2ºDAM',
                'user_credit' => '32'
            ]))->assertRedirect(route('users.show', ['user' => $oldUser]));

        $this->assertDatabaseHas('users', [
            'phone' => '777777777',
            'email' =>'newusertTest@mail.es',
            'class' => '2ºDAM',
        ]);
    }

     /** @test  */
    function phone_must_be_valid()
    {
        $this->handleValidationExceptions();
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

        $userNre = Nre::factory()->create();
        $oldUser = User::factory()->create([
            'nre_id' => $userNre->id,
            'name' => 'Usuario test',
            'phone' => '666666666',
        ]);

        $userNre->update([
            'user_id' => $oldUser->id,
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('users', [
            'phone' => '666666666',
        ]);

        $this->actingAs($admin)->from(route('users.edit', ['user' => $oldUser]))
            ->put(route('users.update', ['user' => $oldUser]), $this->withData([
                'user_phone' => 'formato incrrecto de telefono',
            ]))->assertSessionHasErrors('user_phone')
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('users', [
            'phone' => '666666666',

        ]);
    }
     /** @test  */
    function email_must_be_valid()
    {
        $this->handleValidationExceptions();
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

        $userNre = Nre::factory()->create();
        $oldUser = User::factory()->create([
            'nre_id' => $userNre->id,
            'name' => 'Usuario test',
            'email' =>'usertTest@mail.es',
        ]);

        $userNre->update([
            'user_id' => $oldUser->id,
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('users', [
            'email' =>'usertTest@mail.es',
        ]);

        $this->actingAs($admin)->from(route('users.edit', ['user' => $oldUser]))
            ->put(route('users.update', ['user' => $oldUser]), $this->withData([
                'user_email' =>'email no valido',
            ]))->assertSessionHasErrors('user_email')
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('users', [
            'email' =>'usertTest@mail.es',

        ]);
    }


}
