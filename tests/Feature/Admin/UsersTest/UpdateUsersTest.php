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
    public function it_shows_the_edit_user_page_to_admins()
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
    function an_admin_can__update_a_user()
    {
        $admin = User::factory()->create([
            'name' => 'User1',
            'credit' => 0,
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
            'credit' => 4
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
            'credit' => 4
        ]);

        $this->actingAs($admin)->from(route('users.edit', ['user' => $oldUser]))
            ->put(route('users.update', ['user' => $oldUser]), $this->withData([
                'user_name' => 'nuevo test',
                'user_phone' => '777777777',
                'user_email' =>'newusertTest@mail.es',
                'user_class' => '2ºDAM',
                'user_credit' => 32
            ]));
            
        $this->assertDatabaseHas('users', [
            'name' => 'nuevo test',
            'phone' => '777777777',
            'email' =>'newusertTest@mail.es',
            'class' => '2ºDAM',
            'credit' => 32
        ]);
        
    }
    /** @test  */
    function an_user_can_update_his_info()
    {
        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'User ', // optional
        ]);
        
        $userNre = Nre::factory()->create();
        $oldUser = User::factory()->create([
            'nre_id' => $userNre->id,
            'name' => 'Usuario test',
            'phone' => '666666666',
            'email' =>'usertTest@mail.es',
            'class' => '2ºDAW',
            'credit' => 4
        ]);

        $userNre->update([
            'user_id' => $oldUser->id,
            'updated_at' => now(),
        ]);

        $oldUser->attachRole($userRole);

        $this->assertDatabaseHas('users', [
            'name' => 'Usuario test',
            'phone' => '666666666',
            'email' =>'usertTest@mail.es',
            'class' => '2ºDAW',
            'credit' => 4
        ]);

        $this->actingAs($oldUser)->from(route('users.edit', ['user' => $oldUser]))
            ->put(route('users.update', ['user' => $oldUser]), $this->withData([
                'user_name' => 'nuevo test',
                'user_phone' => '777777777',
                'user_email' =>'newusertTest@mail.es',
                'user_class' => '2ºDAM',
            ]));
            
        $this->assertDatabaseHas('users', [
            'name' => 'nuevo test',
            'phone' => '777777777',
            'email' =>'newusertTest@mail.es',
            'class' => '2ºDAM',
            'credit' => 4
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
               'phone' =>'666666666',
           ]);
   
           $userNre->update([
               'user_id' => $oldUser->id,
               'updated_at' => now(),
           ]);
   
           $this->assertDatabaseHas('users', [
                'phone' =>'666666666',
           ]);
   
           $this->actingAs($admin)->from(route('users.edit', ['user' => $oldUser]))
               ->put(route('users.update', ['user' => $oldUser]), $this->withData([
                   'user_phone' =>'not_valid',
               ]))->assertSessionHasErrors('user_phone')
               ->assertRedirect(url()->previous());
   
           $this->assertDatabaseHas('users', [
                'phone' =>'666666666',
           ]);
       }

       /** @test  */
       function user_cant_update_credit()
       {
           $this->handleValidationExceptions();
           $this->withExceptionHandling();
   
           $userNre = Nre::factory()->create();
           $oldUser = User::factory()->create([
               'nre_id' => $userNre->id,
               'name' => 'Usuario test',
               'credit' =>5,
           ]);
   
           $userNre->update([
               'user_id' => $oldUser->id,
               'updated_at' => now(),
           ]);
   
           $this->assertDatabaseHas('users', [
                'credit' => 5,
           ]);
   
           $this->actingAs($oldUser)->from(route('users.edit', ['user' => $oldUser]))
               ->put(route('users.update', ['user' => $oldUser]), $this->withData([
                   'user_credit' =>10,
               ]));
   
           $this->assertDatabaseHas('users', [
                'credit' =>5,
           ]);
       }

        /** @test  */
       function employees_can_update_user_credit()
       {
            $this->handleValidationExceptions();
            $this->withExceptionHandling();

            $employee = User::factory()->create([
            'name' => 'User1',
            'nre_id' => Nre::factory()->create()->id,
            ]);

            $employeeRole = Role::create([
            'name' => 'employee',
            'display_name' => 'Employee', // optional
            'description' => 'User can update credit', // optional
            ]);

            $employee->attachRole($employeeRole);
   
            $userNre = Nre::factory()->create();
            $oldUser = User::factory()->create([
                'nre_id' => $userNre->id,
                'name' => 'Usuario test',
                'credit' =>5,
            ]);
    
            $userNre->update([
                'user_id' => $oldUser->id,
                'updated_at' => now(),
            ]);

          
           $this->assertDatabaseHas('users', [
                'credit' => 5,
           ]);
   
           $this->actingAs($employee)->from(route('users.edit', ['user' => $oldUser]))
               ->put(route('users.update', ['user' => $oldUser]), $this->withData([
                   'user_credit' =>10,
               ]));
   
           $this->assertDatabaseHas('users', [
                'credit' =>10,
           ]);
       }

        /** @test  */
        function admins_can_update_user_credit()
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
                 'credit' =>5,
            ]);
     
            $userNre->update([
                 'user_id' => $oldUser->id,
                 'updated_at' => now(),
            ]);
 
           
            $this->assertDatabaseHas('users', [
                 'credit' => 5,
            ]);
    
            $this->actingAs($admin)->from(route('users.edit', ['user' => $oldUser]))
                ->put(route('users.update', ['user' => $oldUser]), $this->withData([
                    'user_credit' =>10,
            ]));
    
            $this->assertDatabaseHas('users', [
                 'credit' =>10,
            ]);
        }

        /** @test  */
        public function it_does_not_show_the_credit_field_to_the_user()
        {
            $userRole = Role::create([
                'name' => 'user',
                'display_name' => 'user', // optional
                'description' => 'User not allowed to see credit', // optional
            ]);
            
            $userNre = Nre::factory()->create();
            $user = User::factory()->create([
                'nre_id' => $userNre->id,
                'name' => 'Usuario test',
                'phone' =>'666666666',
            ]);
    
            $userNre->update([
                'user_id' => $user->id,
                'updated_at' => now(),
            ]);

            $user->attachRole($userRole);

            $this->actingAs($user)->get(route('users.edit', ['user' => $user]))
            ->assertStatus(200)
            ->assertSee('Editar Usuario')
            ->assertDontSee('Crédito')
            ->assertSee($user->name);
        }

       /** @test  */
        public function it_shows_the_credit_field_to_admins()
          {
              $admin = User::factory()->create([
                  'name' => 'User1',
                  'nre_id' => Nre::factory()->create()->id,
              ]);
      
              $adminRole = Role::create([
                  'name' => 'administrator',
                  'display_name' => 'Administrator ', // optional
                  'description' => 'User allowed to see the credit', // optional
              ]);
              $admin->attachRole($adminRole);
      
              $user = $this->createRandomUser();
      
              $this->actingAs($admin)->get(route('users.edit', ['user' => $user]))
                  ->assertStatus(200)
                  ->assertSee('Editar Usuario')
                  ->assertSee('Crédito')
                  ->assertSee($user->name);
        }

        /** @test  */
        public function it_shows_the_user_credit_to_employees()
        {
            $employee = User::factory()->create([
                'name' => 'User1',
                'nre_id' => Nre::factory()->create()->id,
            ]);
    
            $employeeRole = Role::create([
                'name' => 'employee',
                'display_name' => 'Employee', // optional
                'description' => 'User can update credit', // optional
            ]);
    
            $employee->attachRole($employeeRole);
       

        $user = $this->createRandomUser();

        $this->actingAs($employee)->get(route('users.edit', ['user' => $user]))
            ->assertStatus(200)
            ->assertSee('Editar Usuario')
            ->assertSee('Crédito')
            ->assertSee($user->name);
    }
       
    

}
