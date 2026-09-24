<?php

namespace App\Http\Requests\Api\V1\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => [
                'required',
                'string',
                'max:150',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
                'before:today',
            ],

            'gender' => [
                'nullable',
                Rule::in([
                    'male',
                    'female',
                    'other',
                ]),
            ],

            // 'gender' => [
            //     'nullable',
            //     'integer',
            //     Rule::in([1, 2, 3]),    //1 = Male 2 = Female 3 = Other

            // ],

            'division_id' => [
                'nullable',
                'integer',
                'exists:divisions,id',
            ],

            'district_id' => [
                'nullable',
                'integer',
                'exists:districts,id',
            ],

            'upazila_id' => [
                'nullable',
                'integer',
                'exists:upazilas,id',
            ],

            'present_address' => [
                'nullable',
                'string',
                'max:500',
            ],

            'permanent_address' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' =>
                'Full name is required.',

            'full_name.max' =>
                'Full name may not be greater than 150 characters.',

            'date_of_birth.date' =>
                'Please enter a valid date of birth.',

            'date_of_birth.before' =>
                'Date of birth must be before today.',

            'gender.in' =>
                'Please select a valid gender.',

            'division_id.exists' =>
                'Selected division is invalid.',

            'district_id.exists' =>
                'Selected district is invalid.',

            'upazila_id.exists' =>
                'Selected upazila/thana is invalid.',

            'present_address.max' =>
                'Present address may not be greater than 500 characters.',

            'permanent_address.max' =>
                'Permanent address may not be greater than 500 characters.',
        ];
    }
}