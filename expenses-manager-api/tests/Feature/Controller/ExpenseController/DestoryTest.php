<?php

namespace Tests\Feature\Controller\ExpenseController;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DestoryTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldDestroyAUserExpense()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $expense = Expense::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson(route('expenses.destroy', $expense->id))->assertStatus(Response::HTTP_OK);

        $this->assertEquals(['message' => 'Expense deleted successfully'], $response->json());
        $this->assertDatabaseMissing('expenses', ['id' => $expense->id]);
    }

    public function testShouldNotAuthorizeIfNotAuthenticated()
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user->id]);
        $response = $this->deleteJson(route('expenses.destroy', $expense->id))->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertEquals(['message' => 'Unauthenticated.'], $response->json());
    }

    public function testShouldNotAuthorizeIfNotExpenseOwner()
    {
        $userOwner = User::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $expense = Expense::factory()->create(['user_id' => $userOwner->id]);

        $response = $this->deleteJson(route('expenses.destroy', $expense->id))->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertEquals('Você não tem permissão para acessar este recurso.', $response->json()['message']);
    }
}
