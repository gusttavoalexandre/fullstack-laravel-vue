<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseNotification extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'notified_at',
        'user_id',
        'expense_id'
    ];

    protected $casts = [
        'notified_at' => 'datetime'
    ];
}
