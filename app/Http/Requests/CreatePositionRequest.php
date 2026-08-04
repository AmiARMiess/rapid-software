<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreatePositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'integer', 'exists:departments,id'],
            'reporting_to' => ['nullable', 'integer', 'exists:positions,id'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'integer', 'exists:option_statuses,id'],
            'level' => ['nullable', 'integer', 'exists:option_levels,id'],
            'responsibilities' => ['nullable', 'array'],
            'responsibilities.*' => ['nullable', 'string', 'max:255'],
        ];
    }
}
