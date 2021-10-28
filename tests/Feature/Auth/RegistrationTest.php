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
        $nre = Nre::factory()->create();
        $response = $this->post('/register', [
            'name' => 'Test User',
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
        Nre::factory()->create(['nre' => '1889417']);

        $this->post('/register', [
            'name' => 'Test User',
            'nre' => '1991234',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
    }
}
