<?php

namespace Tests\Feature\Auth;

use App\Models\{Nre, User};
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
        $response = $this->post('/register', [
            'name' => 'Test User',
            'nre' => Nre::factory()->create()->nre,
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_new_users_cannot_register_if_nre_is_invalid()
    {
        $this->handleValidationExceptions();

        $this->post('/register', [
            'name' => 'Test User',
            'nre' => 'nre199222',
            'email' => 'invalid-email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
    }

    public function test_new_users_cannot_register_if_nre_doesnt_exist()
    {
        $this->handleValidationExceptions();

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

    public function test_new_users_cannot_have_the_same_associated_nre()
    {
        $this->handleValidationExceptions();

        $nre = Nre::factory()->create();
        $user = User::factory()->create([
            'nre_id' => $nre->id,
        ]);
        $nre->update([
            'user_id' => $user->id,
            'updated_at' => now(),
        ]);

        $this->post('/register', [
            'name' => 'Test User',
            'nre' => $nre->nre,
            'email' => 'test@example.com',
            'phone' => '652381947',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_new_users_cannot_register_if_email_is_invalid()
    {
        $this->handleValidationExceptions();

        $this->post('/register', [
            'name' => 'Test User',
            'nre' => Nre::factory()->create()->nre,
            'email' => 'invalid-email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
    }
}
