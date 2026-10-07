<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreMarketplaceJobRequest;
use App\Models\MarketplaceJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class MarketplaceJobController extends Controller
{
    /**
     * Create a new marketplace job.
     */
    public function store(
        StoreMarketplaceJobRequest $request
    ): JsonResponse {
        try {

            $job = DB::transaction(function () use ($request) {

                $data = $request->validated();

                /*
                |--------------------------------------------------------------------------
                | Hirer
                |--------------------------------------------------------------------------
                |
                | hirer_id কখনো client request থেকে নেওয়া হবে না।
                | Authenticated user automatically hirer হবে।
                |
                */
                $data['hirer_id'] = $request->user()->id;

                /*
                |--------------------------------------------------------------------------
                | Initial Job Status
                |--------------------------------------------------------------------------
                |
                | নতুন job সবসময় open অবস্থায় তৈরি হবে।
                |
                */
                $data['status'] = 'open';

                /*
                |--------------------------------------------------------------------------
                | Instant Job
                |--------------------------------------------------------------------------
                |
                | Instant job-এর scheduled_at প্রয়োজন নেই।
                | Client ভুল করে পাঠালেও NULL করে দেওয়া হবে।
                |
                */
                if ($data['job_type'] === 'instant') {
                    $data['scheduled_at'] = null;
                }

                return MarketplaceJob::create($data);
            });

            /*
            |--------------------------------------------------------------------------
            | Load Relationships
            |--------------------------------------------------------------------------
            */
            $job->load([
                'hirer:id,mobile,status',
                'category:id,name,slug',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Marketplace job created successfully.',
                'data' => [
                    'job' => $job,
                ],
            ], 201);

        } catch (Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create marketplace job.',
                'data' => null,
            ], 500);
        }
    }
}