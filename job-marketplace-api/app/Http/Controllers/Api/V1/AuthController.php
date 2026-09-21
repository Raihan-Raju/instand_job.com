<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = DB::transaction(function () use ($data) {

            $user = User::create([
                'mobile' => $data['mobile'],
                'password' => $data['password'],
                'status' => 1,
            ]);

            UserProfile::create([
                'user_id' => $user->id,
            ]);

            $token = $user
                ->createToken('auth-token')
                ->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Registration successful.',
            'data' => [
                'user' => [
                    'id' => $result['user']->id,
                    'mobile' => $result['user']->mobile,
                    'status' => $result['user']->status,
                ],
                'token_type' => 'Bearer',
                'access_token' => $result['token'],
            ],
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::where('mobile', $data['mobile'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid mobile number or password.',
            ], 401);
        }

        if ((int) $user->status !== 1) {
            $message = match ((int) $user->status) {
                0 => 'Your account is inactive.',
                2 => 'Your account is suspended.',
                3 => 'Your account is blocked.',
                default => 'Your account is not active.',
            };

            return response()->json([
                'success' => false,
                'message' => $message,
            ], 403);
        }

        $user->update([
            'last_login_at' => now(),
        ]);

        // আপাতত latest login token-টাই active রাখছি।
        $user->tokens()->delete();

        $token = $user
            ->createToken('auth-token')
            ->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'mobile' => $user->mobile,
                    'status' => $user->status,
                    'last_login_at' => $user->last_login_at,
                ],
                'token_type' => 'Bearer',
                'access_token' => $token,
            ],
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load('profile');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'mobile' => $user->mobile,
                'mobile_verified_at' => $user->mobile_verified_at,
                'status' => $user->status,
                'last_login_at' => $user->last_login_at,
                'profile' => $user->profile,
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()
            ->currentAccessToken()
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.',
        ]);
    }
}