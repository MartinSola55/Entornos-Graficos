<?php

namespace App\Http\Requests\Pps;

use App\Http\Requests\BaseFormRequest;

class PpsRequest extends BaseFormRequest
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
            'description' => ['required', 'string', 'max:255'],
        ]);

        return [
            'description',
        ];
    }
}
