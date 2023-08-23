<?php

namespace App\Http\Requests\Application;

use App\Http\Requests\BaseFormRequest;

class ApplicationUpdateRequest extends BaseFormRequest
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
            'student_id' => ['required', 'integer', 'exists:persons,id'],
            'responsible_id' => ['required', 'integer', 'exists:persons,id'],
            'teacher_id' => ['required', 'integer', 'exists:persons,id'],
            'is_finished' => ['nullable', 'boolean'],
            'is_approved' => ['nullable', 'boolean'],
            'observation' => ['nullable', 'string', 'max:255'],
        ]);

        return [
            'student_id',
            'responsible_id',
            'teacher_id',
            'pps_id',
            'is_finished',
            'is_approved',
            'observation',
        ];
    }
}
