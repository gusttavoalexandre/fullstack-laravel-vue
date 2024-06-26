<?php

namespace App\Http\Requests\Expense;

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class ExpenseUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    try {
                        $date = Carbon::parse($value);
                    } catch (InvalidFormatException $e) {
                        $fail('The '.$attribute.' invalid date format.');

                        return;
                    }

                    if ($date->greaterThan(Carbon::today()->endOfDay())) {
                        $fail('The '.$attribute.' cannot be in the future.');
                    }
                },
            ],
            'value' => 'required|numeric|min:0.01',
        ];
    }
}
