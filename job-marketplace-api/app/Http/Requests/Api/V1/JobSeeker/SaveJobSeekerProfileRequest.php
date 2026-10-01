<?php

namespace App\Http\Requests\Api\V1\JobSeeker;

use Illuminate\Foundation\Http\FormRequest;

class SaveJobSeekerProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Job Seeker Profile
            |--------------------------------------------------------------------------
            */

            'professional_title' => [
                'nullable',
                'string',
                'max:150',
            ],

            'about' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'experience_years' => [
                'required',
                'integer',
                'min:0',
                'max:80',
            ],

            'hourly_rate' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999999.99',
            ],

            'daily_rate' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999999.99',
            ],


            /*
            |--------------------------------------------------------------------------
            | Multiple Job Categories
            |--------------------------------------------------------------------------
            */

            'category_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'category_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:job_categories,id',
            ],


            /*
            |--------------------------------------------------------------------------
            | Multiple Skills
            |--------------------------------------------------------------------------
            */

            'skill_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'skill_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:skills,id',
            ],

        ];
    }


    public function messages(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Job Seeker Profile Messages
            |--------------------------------------------------------------------------
            */

            'professional_title.max' =>
                'Professional title may not be greater than 150 characters.',

            'about.max' =>
                'About may not be greater than 2000 characters.',

            'experience_years.required' =>
                'Experience years is required.',

            'experience_years.integer' =>
                'Experience years must be a valid number.',

            'experience_years.min' =>
                'Experience years cannot be negative.',

            'experience_years.max' =>
                'Experience years may not be greater than 80.',

            'hourly_rate.numeric' =>
                'Hourly rate must be a valid number.',

            'hourly_rate.min' =>
                'Hourly rate cannot be negative.',

            'daily_rate.numeric' =>
                'Daily rate must be a valid number.',

            'daily_rate.min' =>
                'Daily rate cannot be negative.',


            /*
            |--------------------------------------------------------------------------
            | Category Messages
            |--------------------------------------------------------------------------
            */

            'category_ids.required' =>
                'Please select at least one job category.',

            'category_ids.array' =>
                'Job categories must be provided as an array.',

            'category_ids.min' =>
                'Please select at least one job category.',

            'category_ids.*.integer' =>
                'Each job category ID must be a valid integer.',

            'category_ids.*.distinct' =>
                'Duplicate job categories are not allowed.',

            'category_ids.*.exists' =>
                'One or more selected job categories are invalid.',


            /*
            |--------------------------------------------------------------------------
            | Skill Messages
            |--------------------------------------------------------------------------
            */

            'skill_ids.required' =>
                'Please select at least one skill.',

            'skill_ids.array' =>
                'Skills must be provided as an array.',

            'skill_ids.min' =>
                'Please select at least one skill.',

            'skill_ids.*.integer' =>
                'Each skill ID must be a valid integer.',

            'skill_ids.*.distinct' =>
                'Duplicate skills are not allowed.',

            'skill_ids.*.exists' =>
                'One or more selected skills are invalid.',

        ];
    }
}