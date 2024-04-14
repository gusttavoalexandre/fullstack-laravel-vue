<?php

namespace Tests\Feature\Controller\AuthController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldBeLogout()
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson(route('auth.logout'))->assertStatus(200);
    }

    public function testShouldBeReturnErrorWithUnauthenticated()
    {
        $this->postJson(route('auth.logout'))->assertStatus(401)->assertSee('Unauthenticated');
    }
}
