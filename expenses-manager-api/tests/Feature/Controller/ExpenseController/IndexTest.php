<?php

namespace Tests\Feature\Controller\ExpenseController;

use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldListAllUserExpenses()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $expenses = Expense::factory(5)->create(['user_id' => $user->id]);

        $response = $this->getJson(route('expenses.index'))->assertStatus(Response::HTTP_OK);
        $expected = ExpenseResource::collection($expenses)->response()->getData(true);

        $this->assertIsArray($response->json());
        $this->assertArrayHasKey('data', $response->json());
        $this->assertCount(5, $response->json('data'));
        $this->assertEquals($expected['data'], $response->json('data'));
    }

    public function testShouldNotAuthorizeIfNotAuthenticated()
    {
        $response = $this->getJson(route('expenses.index'))->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertEquals(['message' => 'Unauthenticated.'], $response->json());
    }
}
