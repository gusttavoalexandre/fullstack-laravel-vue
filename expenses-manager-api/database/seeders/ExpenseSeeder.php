<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function (User $user) {
            Expense::factory(2)
                ->create([
                    'value' => 100.21,
                    'user_id' => $user->id,
                ]);
            Expense::factory(3)
                ->create([
                    'user_id' => $user->id,
                ]);
        });

        Expense::all()->each(function (Expense $expense) {
            $expense->notification()->create([
                'user_id' => $expense->user_id,
                'notified_at' => now(),
            ]);
        });
    }
}
