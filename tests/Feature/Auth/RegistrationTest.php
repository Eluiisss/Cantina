<?php

namespace Tests\Feature\Auth;

use App\Models\Nre;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        //$this->withoutExceptionHandling();
        
        $nre = Nre::create([
            'nre' => '1888714',
        ]);
        $response = $this->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'nre' => $nre->nre,
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_new_users_cannot_register_if_nre_doesnt_exist()
    {
        //$this->withoutExceptionHandling();
        
        $nre = Nre::create([
            'nre' => '1888714',
        ]);
        $response = $this->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'nre' => '1888715',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
    }
}
