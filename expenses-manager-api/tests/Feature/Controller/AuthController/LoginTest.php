<?php

namespace Tests\Feature\Controller\AuthController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldBeLoginWithSuccess()
    {
        $password = 'secret@123';
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => $password,
        ])->assertStatus(200)->assertJsonStructure(['access_token', 'token_type']);
    }

    public function testShouldNotLoginWithInvalidCredentials()
    {
        $password = 'secret@123';
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => $password . '123',
        ])->assertStatus(401)->assertJson(['message' => 'Email ou senha inválidos']);
    }

    public function testShouldValidateRequiredFields()
    {
        $params = [
            'email' => '',
            'password' => '',
        ];

        $this->postJson(route('auth.login'), $params)->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }
}
