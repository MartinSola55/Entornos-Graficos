<?php

namespace App\Http\Requests\Application;

use App\Http\Requests\BaseFormRequest;

class ApplicationCreateRequest extends BaseFormRequest
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
            'pps_id' => ['required', 'integer', 'exists:pps,id'],
        ]);

        return [
            'pps_id',
        ];
    }
}
