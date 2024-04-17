<?php

namespace App\Http\Requests\Expense;

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class ExpenseStoreRequest extends FormRequest
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
                function ($attribute, $value, $fail) {
                    try {
                        $date = Carbon::createFromFormat('d/m/Y', $value);
                    } catch (InvalidFormatException $e) {
                        $fail('A '.$attribute.' deve seguir o formato d/m/Y.');

                        return;
                    }

                    if ($date->greaterThan(Carbon::today()->endOfDay())) {
                        $fail('A '.$attribute.' não pode ser no futuro.');
                    }
                },
            ],
            'value' => 'required|numeric|min:0.01',
        ];
    }
}
