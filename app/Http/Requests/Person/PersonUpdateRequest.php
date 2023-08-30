<?php

namespace App\Http\Requests\Person;

use App\Http\Requests\BaseFormRequest;

class PersonUpdateRequest extends BaseFormRequest
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
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'file_number' => ['required', 'string', 'max:255']
        ]);

        return [
            'name',
            'lastname',
            'address',
            'phone',
            'file_number',
        ];
    }
}
