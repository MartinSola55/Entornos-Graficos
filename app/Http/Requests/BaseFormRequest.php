<?php

namespace App\Http\Requests;

use App\Exceptions\AuthenticateException;
use App\Exceptions\ApiFailedValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new ApiFailedValidationException($validator);
    }
}
