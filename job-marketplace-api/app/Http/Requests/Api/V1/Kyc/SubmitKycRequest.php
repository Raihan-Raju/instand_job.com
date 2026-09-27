<?php

namespace App\Http\Requests\Api\V1\Kyc;

use Illuminate\Foundation\Http\FormRequest;

class SubmitKycRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nid_number' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                'min:10',
                'max:30',
            ],

            'nid_front' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'nid_back' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nid_number.required' =>
                'NID number is required.',

            'nid_number.string' =>
                'NID number must be a valid string.',

            'nid_number.regex' =>
                'NID number must contain digits only.',

            'nid_number.min' =>
                'NID number must be at least 10 digits.',

            'nid_number.max' =>
                'NID number may not be greater than 30 digits.',

            'nid_front.required' =>
                'NID front image is required.',

            'nid_front.image' =>
                'NID front file must be an image.',

            'nid_front.mimes' =>
                'NID front image must be JPG, JPEG, PNG or WEBP.',

            'nid_front.max' =>
                'NID front image must not exceed 5 MB.',

            'nid_back.required' =>
                'NID back image is required.',

            'nid_back.image' =>
                'NID back file must be an image.',

            'nid_back.mimes' =>
                'NID back image must be JPG, JPEG, PNG or WEBP.',

            'nid_back.max' =>
                'NID back image must not exceed 5 MB.',
        ];
    }
}