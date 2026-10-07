<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMarketplaceJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * Authentication route-এর auth:sanctum middleware
     * দ্বারা handle হবে।
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Job Category
            |--------------------------------------------------------------------------
            */
            'job_category_id' => [
                'required',
                'integer',
                Rule::exists('job_categories', 'id')
                    ->where('status', 1),
            ],

            /*
            |--------------------------------------------------------------------------
            | Basic Job Information
            |--------------------------------------------------------------------------
            */
            'title' => [
                'required',
                'string',
                'max:150',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            /*
            |--------------------------------------------------------------------------
            | Job Type
            |--------------------------------------------------------------------------
            |
            | instant   = এখনই worker দরকার
            | scheduled = future date/time-এ worker দরকার
            |
            */
            'job_type' => [
                'required',
                Rule::in([
                    'instant',
                    'scheduled',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Rate / Payment Basis
            |--------------------------------------------------------------------------
            */
            'rate_type' => [
                'required',
                Rule::in([
                    'hourly',
                    'daily',
                    'fixed',
                ]),
            ],

            'rate_amount' => [
                'required',
                'numeric',
                'gt:0',
                'max:9999999999.99',
            ],

            /*
            |--------------------------------------------------------------------------
            | Required Workers
            |--------------------------------------------------------------------------
            */
            'workers_required' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            /*
            |--------------------------------------------------------------------------
            | Hire Mode
            |--------------------------------------------------------------------------
            |
            | manual = worker pin/profile থেকে Direct Hire
            | auto   = nearest-first automatic dispatch
            |
            */
            'hire_mode' => [
                'required',
                Rule::in([
                    'manual',
                    'auto',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Search Mode
            |--------------------------------------------------------------------------
            |
            | current = current GPS location
            | manual  = map থেকে manually selected location
            |
            */
            'search_mode' => [
                'required',
                Rule::in([
                    'current',
                    'manual',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Job Location
            |--------------------------------------------------------------------------
            |
            | Job create করার সময় final selected/search location
            | marketplace_jobs table-এ snapshot হিসেবে save হবে।
            |
            */
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

            'search_radius_km' => [
                'required',
                'numeric',
                'gt:0',
                'max:100',
            ],

            'location_address' => [
                'nullable',
                'string',
                'max:500',
            ],

            /*
            |--------------------------------------------------------------------------
            | Scheduled Job Date / Time
            |--------------------------------------------------------------------------
            |
            | scheduled job হলে অবশ্যই future date/time দিতে হবে।
            | instant job হলে field না দিলেও হবে।
            |
            */
            'scheduled_at' => [
                Rule::requiredIf(
                    fn () => $this->input('job_type') === 'scheduled'
                ),
                'nullable',
                'date',
                'after:now',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'job_category_id.required' =>
                'Job category is required.',

            'job_category_id.exists' =>
                'Selected job category is invalid or inactive.',

            'title.required' =>
                'Job title is required.',

            'job_type.required' =>
                'Job type is required.',

            'job_type.in' =>
                'Job type must be instant or scheduled.',

            'rate_type.required' =>
                'Rate type is required.',

            'rate_type.in' =>
                'Rate type must be hourly, daily, or fixed.',

            'rate_amount.required' =>
                'Rate amount is required.',

            'rate_amount.gt' =>
                'Rate amount must be greater than zero.',

            'workers_required.required' =>
                'Required worker count is required.',

            'workers_required.min' =>
                'At least one worker is required.',

            'workers_required.max' =>
                'Maximum 100 workers can be requested for one job.',

            'hire_mode.required' =>
                'Hire mode is required.',

            'hire_mode.in' =>
                'Hire mode must be manual or auto.',

            'search_mode.required' =>
                'Search mode is required.',

            'search_mode.in' =>
                'Search mode must be current or manual.',

            'latitude.required' =>
                'Job location latitude is required.',

            'latitude.between' =>
                'Latitude must be between -90 and 90.',

            'longitude.required' =>
                'Job location longitude is required.',

            'longitude.between' =>
                'Longitude must be between -180 and 180.',

            'search_radius_km.required' =>
                'Search radius is required.',

            'search_radius_km.gt' =>
                'Search radius must be greater than zero.',

            'search_radius_km.max' =>
                'Search radius cannot be greater than 100 km.',

            'scheduled_at.required' =>
                'Scheduled date and time is required for a scheduled job.',

            'scheduled_at.date' =>
                'Scheduled date and time is invalid.',

            'scheduled_at.after' =>
                'Scheduled date and time must be in the future.',
        ];
    }
}