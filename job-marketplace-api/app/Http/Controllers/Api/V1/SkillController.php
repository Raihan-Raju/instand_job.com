<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;

class SkillController extends Controller
{
    public function index(): JsonResponse
    {
        $skills = Skill::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'slug',
                'description',
                'status',
                'sort_order',
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Skills retrieved successfully.',
            'data' => $skills,
        ], 200);
    }
}