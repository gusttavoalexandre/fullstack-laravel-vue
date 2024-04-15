<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExpensePolicy
{
    public function touch(User $user, Expense $expense): Response
    {
        return $user->id === $expense->user_id ? Response::allow()
            : Response::deny('Você não tem permissão para acessar este recurso.');
    }
}
