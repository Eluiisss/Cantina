<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Nre;
use App\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function it_shows_the_users_list_to_admins(){

        $user = User::factory()->create([
            'name' => 'User1',
            'nre_id' => Nre::factory()->create()->id,
        ]);

        $user2 = User::factory()->create([
            'name' => 'User2',
            'nre_id' => Nre::factory()->create()->id,
        ]);

        $user3 = User::factory()->create([
            'name' => 'User3',
            'nre_id' => Nre::factory()->create()->id,
        ]);

        $admin = Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator ', // optional
            'description' => 'User allowed to see the index of users', // optional
        ]);
        $user->attachRole($admin);

        $response = $this->actingAs($user)->get('/admin/users');

        $response->assertStatus(200);

        $response->assertSeeInOrder([
            $user->name,
            $user2->name,
            $user3->name,
        ]);
    }

       /** @test  */
      public function it_paginate_the_users()
    {
        $nre = Nre::factory()->create();
        $userAd = User::factory()->create([
            'name' => 'User1',
            'nre_id' => $nre->id,
        ]);
        $admin = Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator ', // optional
            'description' => 'User allowed to see the index of users', // optional
        ]);
        $userAd->attachRole($admin);

        $nre2 = Nre::factory()->create();
        $nre3 = Nre::factory()->create();


        User::factory()->create(['name' => 'AAUserPage1','nre_id' => $nre2->id]);
        foreach (range(1, 15) as $i) {
            $this->createRandomUser();
        }
        User::factory()->create(['name' => 'ZZUserPage2','nre_id' => $nre3->id]);


        $response = $this->actingAs($userAd)->get(route('users.index', ['page'=>'1']))->assertStatus(200);
        $response->assertSee(['AAUserPage1']);
        $response->assertDontSee('ZZUserPage2');


        $response = $this->actingAs($userAd)->get(route('users.index', ['page'=>'2']))->assertStatus(200);
        $response->assertSee(['ZZUserPage2']);
        $response->assertDontSee('AAUserPage1');

    }

    /** @test  */
    public function admin_can_ban_unbanned_user_from_index(){
        $nre = Nre::factory()->create();
        $userAd = User::factory()->create([
            'name' => 'User1',
            'nre_id' => $nre->id,
            'banned' => 1,
        ]);
        $admin = Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator ', // optional
            'description' => 'User allowed to see the index of users', // optional
        ]);
        $userAd->attachRole($admin);
        $this->assertDatabaseHas('users', [
            'name' => $userAd->name,
            'banned' => 1
        ]);

        $response = $this->actingAs($userAd)->get(route('users.bann', ['id' => $userAd->id]));
        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => $userAd->name,
            'banned' => 0
        ]);
    }

    /** @test  */
    public function admin_can_unbann_banned_user_from_index(){
        $nre = Nre::factory()->create();
        $userAd = User::factory()->create([
            'name' => 'User1',
            'nre_id' => $nre->id,
            'banned' => 0,
        ]);
        $admin = Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator ', // optional
            'description' => 'User allowed to see the index of users', // optional
        ]);
        $userAd->attachRole($admin);
        $this->assertDatabaseHas('users', [
            'name' => $userAd->name,
            'banned' => 0
        ]);

        $response = $this->actingAs($userAd)->get(route('users.bann', ['id' => $userAd->id]));
        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => $userAd->name,
            'banned' => 1
        ]);
    }

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
    }

    public function createAdmin($name)
    {
        $admin = User::factory()->create([
            'name' => $name,
            'nre_id' => Nre::factory()->create()->id,
        ]);

        $adminRole = Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator ', // optional
        ]);
        $admin->attachRole($adminRole);
    
    }

    public function createEmplolyee($name)
    {
        $admin = User::factory()->create([
            'name' => $name,
            'nre_id' => Nre::factory()->create()->id,
        ]);

        $adminRole = Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator ', // optional
        ]);
        $admin->attachRole($adminRole);
    
    }



}
