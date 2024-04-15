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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
