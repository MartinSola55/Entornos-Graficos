<?php

namespace App\Http\Requests\Person;

use App\Http\Requests\BaseFormRequest;

class PersonShowRequest extends BaseFormRequest
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
            'id' => ['required', 'exists:students,id'],
        ]);

        return [
            'name',
            'lastname',
            'address',
            'phone',
            'file_number',
            'email',
        ];
    }
}
