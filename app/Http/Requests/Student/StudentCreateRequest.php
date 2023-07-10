<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\BaseFormRequest;

class StudentCreateRequest extends BaseFormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'adress' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'dni' => ['required', 'string', 'max:255'],
            'file_number' => ['required', 'string', 'max:255'],
            'observation' => ['nullable', 'string'],
        ]);

        return [
            'name',
            'lastname',
            'adress',
            'phone',
            'dni',
            'is_active',
            'file_number',
            'observation',
            'user_id'
        ];
    }
}
