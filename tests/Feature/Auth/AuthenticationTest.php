<?php

namespace Tests\Feature\Auth;

use App\Models\Nre;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $nre = Nre::factory()->create();
        $user = User::factory()->create([
            'nre_id' => $nre->id,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_email()
    {
        $this->handleValidationExceptions();

        $nre = Nre::factory()->create();
        User::factory()->create([
            'nre_id' => $nre->id,
        ]);

        $this->post('/login', [
            'email' => 'pepito.com',
            'password' => 'password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_if_email_doesnt_exist()
    {
        $this->handleValidationExceptions();

        $nre = Nre::factory()->create();
        User::factory()->create([
            'email' => 'pepito1@mail.es',
            'nre_id' => $nre->id,
        ]);

        $this->post('/login', [
            'email' => 'pepito2@mail.es',
            'password' => 'password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $this->handleValidationExceptions();

        $nre = Nre::factory()->create();
        $user = User::factory()->create([
            'nre_id' => $nre->id,
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
