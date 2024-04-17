<?php

namespace App\Http\Controllers;

use App\Http\Actions\GetExpensesStatus;
use App\Http\Requests\Expense\ExpenseStoreRequest;
use App\Http\Requests\Expense\ExpenseUpdateRequest;
use App\Http\Resources\ExpenseResource;
use App\Jobs\SendExpenseNotificationJob;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class ExpenseController
{
    public function index(): AnonymousResourceCollection
    {
        return ExpenseResource::collection(
            auth()->user()->expenses()->get()
        );
    }

    public function store(ExpenseStoreRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        $inputs['date'] = Carbon::createFromFormat('d/m/Y', $inputs['date']);
        $expense = auth()->user()->expenses()->create($inputs);

        $notification = $expense->notification()->create(['user_id' => auth()->id()]);

        SendExpenseNotificationJob::dispatch($notification);

        return response()->json(new ExpenseResource($expense), Response::HTTP_CREATED);
    }

    public function show(Expense $expense): ExpenseResource
    {
        Gate::authorize('touch', $expense);

        return new ExpenseResource($expense);
    }

    public function update(ExpenseUpdateRequest $request, Expense $expense): ExpenseResource
    {
        Gate::authorize('touch', $expense);

        $inputs = $request->validated();

        $expense->update($inputs);

        return new ExpenseResource($expense);
    }

    public function destroy(Expense $expense)
    {
        Gate::authorize('touch', $expense);

        $expense->delete();

        return response()->json(['message' => 'Expense deleted successfully']);
    }

    public function status(): JsonResponse
    {
        return response()->json(GetExpensesStatus::execute(auth()->user()));
    }
}
