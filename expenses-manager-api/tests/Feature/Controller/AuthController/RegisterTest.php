<?php

namespace Tests\Feature\Controller\AuthController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldBeRegisterUserWithSuccess()
    {
        $password = 'secret@123';
        $params = User::factory()->make()->toArray();
        $params['password'] = $password;
        $params['password_confirmation'] = $password;

        $this->postJson(route('auth.register'), $params)->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type']);

        unset($params['password']);
        unset($params['password_confirmation']);
        $this->assertDatabaseHas('users', $params);
    }

    public function testShouldValidateRequiredFields()
    {
        $params = [
            'name' => '',
            'email' => '',
            'password' => '',
        ];

        $this->postJson(route('auth.register'), $params)->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }
}
