<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Divisions
    |--------------------------------------------------------------------------
    */

    public function divisions(): JsonResponse
    {
        $divisions = Division::query()
            ->where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->get([
                'id',
                'name_en',
                'name_bn',
                'code',
            ]);

        return response()->json([
            'success' => true,
            'data' => $divisions,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Districts By Division
    |--------------------------------------------------------------------------
    */

    public function districts(int $divisionId): JsonResponse
    {
        $division = Division::query()
            ->where('id', $divisionId)
            ->where('status', 1)
            ->first();

        if (!$division) {
            return response()->json([
                'success' => false,
                'message' => 'Division not found.',
            ], 404);
        }

        $districts = District::query()
            ->where('division_id', $division->id)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->get([
                'id',
                'division_id',
                'name_en',
                'name_bn',
                'code',
            ]);

        return response()->json([
            'success' => true,
            'data' => $districts,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Upazilas / Thanas By District
    |--------------------------------------------------------------------------
    */

    public function upazilas(int $districtId): JsonResponse
    {
        $district = District::query()
            ->where('id', $districtId)
            ->where('status', 1)
            ->first();

        if (!$district) {
            return response()->json([
                'success' => false,
                'message' => 'District not found.',
            ], 404);
        }

        $upazilas = Upazila::query()
            ->where('district_id', $district->id)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('name_en')
            ->get([
                'id',
                'district_id',
                'name_en',
                'name_bn',
                'type',
                'code',
            ]);

        return response()->json([
            'success' => true,
            'data' => $upazilas,
        ]);
    }
}