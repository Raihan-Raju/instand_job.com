<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\JsonResponse;

class JobCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = JobCategory::query()
            ->where('status', true)
            ->whereNull('parent_id')
            ->with([
                'children' => function ($query) {
                    $query->where('status', true)
                        ->orderBy('sort_order')
                        ->orderBy('name');
                }
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'slug',
                'description',
                'icon',
                'parent_id',
                'sort_order',
                'status',
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Job categories retrieved successfully.',
            'data' => $categories,
        ], 200);
    }
}