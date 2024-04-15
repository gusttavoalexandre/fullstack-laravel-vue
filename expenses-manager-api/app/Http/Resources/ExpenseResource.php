<?php

namespace App\Http\Resources;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Expense
 *
 * @property mixed $formatted_value
 */
class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'formatted_value' => $this->formatted_value,
            'formatted_date' => $this->date->format('d/m/Y'),
            'value' => $this->value,
            'date' => $this->date->format('Y-m-d'),
        ];
    }
}
