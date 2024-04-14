<?php

namespace Tests\Feature\Controller\AuthController;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MeTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldBeReturnAuthUser()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson(route('auth.me'))->assertStatus(200);
        #TODO Fazer bind disso no phpunit (new UserResource($user))->toArray(request())
        $this->assertEquals((new UserResource($user))->toArray(request()), $response->json());
    }

    public function testShouldBeReturnErrorWithUnauthenticated()
    {
        $this->getJson(route('auth.me'))
            ->assertStatus(401)
            ->assertSee('Unauthenticated');
    }
}
