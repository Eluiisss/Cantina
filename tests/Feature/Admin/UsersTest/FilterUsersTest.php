<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Nre;
use App\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function it_filters_by_role(){

        $this->createRandomUser('estudiante');
        $this->createAdmin('jefe');
        $this->createEmployee('cantinero');

        $admin = User::factory()->create([
            'name' => 'admin',
            'nre_id' => Nre::factory()->create()->id,
        ]);
        $admin->attachRole('administrator');
        $response = $this->actingAs($admin)->get('/admin/users', ['role' => 'employee'])
        ->assertSee('cantinero')
        ->assertViewMissing('estudiante')
        ->assertViewMissing('jefe');

        $response = $this->actingAs($admin)->get('/admin/users', ['role' => 'user'])
        ->assertSee('estudiante')
        ->assertViewMissing('cantinero')
        ->assertViewMissing('jefe');

        $response = $this->actingAs($admin)->get('/admin/users', ['role' => 'administrator'])
        ->assertSee('jefe')
        ->assertViewMissing('estudiante')
        ->assertViewMissing('cantinero');

        $response = $this->actingAs($admin)->get('/admin/users', ['role' => 'all'])
        ->assertSee('cantinero')
        ->assertSee('estudiante')
        ->assertSee('jefe');
        
        $response->assertStatus(200);

    }   

   /** @test  */
    public function it_partialy_search_users(){

        $this->createRandomUser('estudiante');
        $this->createAdmin('jefe');
        $this->createEmployee('cantinero');

        $admin = User::factory()->create([
            'name' => 'admin',
            'nre_id' => Nre::factory()->create()->id,
        ]);
        $admin->attachRole('administrator');
        
        $response = $this->actingAs($admin)->get('/admin/users', ['search' => 'estu'])
            ->assertSee('estudiante')
            ->assertViewMissing('cantinero')
            ->assertViewMissing('jefe');
    }

    public function createRandomUser($name)
    {
        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'User', // optional
        ]);
        $userNre = Nre::factory()->create();
        $user = User::factory()->create([
            'nre_id' => $userNre->id,
            'name' => $name,
        ]);
        $userNre->update([
            'user_id' => $user->id,
            'updated_at' => now(),
        ]);
        $user->attachRole($userRole);
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

    public function createEmployee($name)
    {
        $employee = User::factory()->create([
            'name' => $name,
            'nre_id' => Nre::factory()->create()->id,
        ]);

        $employeeRole = Role::create([
            'name' => 'employee',
            'display_name' => 'Employee', // optional
        ]);
        $employee->attachRole($employeeRole);
    
    }



}
