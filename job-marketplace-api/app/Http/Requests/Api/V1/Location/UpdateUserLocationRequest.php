<?php

namespace App\Http\Requests\Api\V1\Location;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],

            'accuracy' => [
                'nullable',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'latitude.required' =>
                'Latitude is required.',

            'latitude.numeric' =>
                'Latitude must be a valid number.',

            'latitude.between' =>
                'Latitude must be between -90 and 90.',

            'longitude.required' =>
                'Longitude is required.',

            'longitude.numeric' =>
                'Longitude must be a valid number.',

            'longitude.between' =>
                'Longitude must be between -180 and 180.',

            'accuracy.numeric' =>
                'Accuracy must be a valid number.',

            'accuracy.min' =>
                'Accuracy cannot be negative.',

            'accuracy.max' =>
                'Accuracy value is too large.',
        ];
    }
}