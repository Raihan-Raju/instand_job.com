<?php

namespace App\Http\Requests\Api\V1\Employer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveEmployerProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employer_type' => [
                'required',
                'string',
                Rule::in([
                    'individual',
                    'business',
                ]),
            ],

            'business_name' => [
                'nullable',
                'required_if:employer_type,business',
                'string',
                'max:200',
            ],

            'business_type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'business_description' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'employer_type.required' =>
                'Employer type is required.',

            'employer_type.in' =>
                'Employer type must be individual or business.',

            'business_name.required_if' =>
                'Business name is required for a business employer.',

            'business_name.max' =>
                'Business name may not be greater than 200 characters.',

            'business_type.max' =>
                'Business type may not be greater than 100 characters.',

            'business_description.max' =>
                'Business description may not be greater than 2000 characters.',
        ];
    }
}