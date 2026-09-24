<?php

namespace App\Http\Requests\Api\V1\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UploadProfilePhotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'profile_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'profile_photo.required' =>
                'Profile photo is required.',

            'profile_photo.image' =>
                'The uploaded file must be an image.',

            'profile_photo.mimes' =>
                'Profile photo must be JPG, JPEG, PNG or WEBP.',

            'profile_photo.max' =>
                'Profile photo must not exceed 2 MB.',
        ];
    }
}