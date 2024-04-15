<?php

namespace Tests\Feature\Controller\ExpenseController;

use App\Jobs\SendExpenseNotificationJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldStoreExpense()
    {
        Queue::fake();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $expenseData = [
            'description' => 'Compra de material',
            'date' => Carbon::now()->format('Y-m-d'),
            'value' => 15.00,
            'user_id' => $user->id,
        ];

        $response = $this->postJson(route('expenses.store'), $expenseData);
        $response->assertStatus(Response::HTTP_CREATED);

        $expenseData['value'] = 1500;
        Queue::assertPushed(SendExpenseNotificationJob::class);
        $this->assertDatabaseHas('expenses', $expenseData);
    }

    public function testShouldNotAuthorizeIfNotAuthenticated()
    {
        $response = $this->postJson(route('expenses.store'))->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertEquals(['message' => 'Unauthenticated.'], $response->json());
    }
}
