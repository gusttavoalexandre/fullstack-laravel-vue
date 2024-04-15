<?php

namespace Tests\Feature\Controller\ExpenseController;

use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldShowAUserExpense()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $expense = Expense::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson(route('expenses.show', $expense->id))->assertStatus(Response::HTTP_OK);

        $expected = (new ExpenseResource($expense))->response()->getData(true);

        $this->assertEquals($expected['data'], $response->json('data'));
    }

    public function testShouldNotAuthorizeIfNotAuthenticated()
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user->id]);
        $response = $this->getJson(route('expenses.show', $expense->id))->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertEquals(['message' => 'Unauthenticated.'], $response->json());
    }

    public function testShouldNotAuthorizeIfNotExpenseOwner()
    {
        $userOwner = User::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $expense = Expense::factory()->create(['user_id' => $userOwner->id]);

        $response = $this->getJson(route('expenses.show', $expense->id))->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertEquals('Você não tem permissão para acessar este recurso.', $response->json()['message']);
    }
}
