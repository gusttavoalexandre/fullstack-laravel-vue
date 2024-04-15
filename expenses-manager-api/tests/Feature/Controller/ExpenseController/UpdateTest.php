<?php

namespace Tests\Feature\Controller\ExpenseController;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldUpdateExpense()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $expense = Expense::factory()->create(['user_id' => $user->id]);
        $data = Expense::factory()->make()->toArray();

        $this->putJson(route('expenses.update', $expense->id), $data)->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id,
            'description' => $data['description'],
        ]);
    }

    public function testShouldNotAuthorizeIfNotAuthenticated()
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user->id]);
        $response = $this->putJson(route('expenses.update', $expense->id))->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertEquals(['message' => 'Unauthenticated.'], $response->json());
    }

    public function testShouldNotAuthorizeIfNotExpenseOwner()
    {
        $userOwner = User::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $expense = Expense::factory()->create(['user_id' => $userOwner->id]);
        $data = Expense::factory()->make()->toArray();

        $response = $this->putJson(route('expenses.update', $expense->id), $data)->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertEquals('Você não tem permissão para acessar este recurso.', $response->json()['message']);
    }
}
