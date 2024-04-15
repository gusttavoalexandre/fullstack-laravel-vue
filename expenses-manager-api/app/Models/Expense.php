<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'date',
        'value',
    ];

    protected $casts = [
        'date' => 'date',
        'value' => MoneyCast::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notification(): HasOne
    {
        return $this->hasOne(ExpenseNotification::class);
    }

    protected function formattedValue(): Attribute
    {
        return new Attribute(
            get: fn () => 'R$ '.number_format((float) $this->value, 2, ',', '.'),
        );
    }
}
