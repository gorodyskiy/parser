<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register new user.
     * 
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($user) {
            $user->sendEmailVerificationNotification();
            return response()->json([
                'success' => true,
                'message' => 'User registered successfully. Please confirm email.',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Error.',
        ], 500);
    }

    /**
     * Authentificate user.
     * 
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->safe()->toArray())) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'message' => 'User login successfully.',
                'data' => [
                    'user' => $user->name,
                    'token' => $user->createToken($user->name)->plainTextToken,
                    'token_type' => 'Barear',
                ],
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Error.',
        ], 500);
    }

    /**
     * Logout user.
     * 
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        if (Auth::user()->currentAccessToken()->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'User logout successfully.',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Error.',
        ], 500);
    }

    /**
     * Verify email and create API token.
     * 
     * @param int $user_id
     * @param Request $request
     * @return JsonResponse
     */
    public function verify($user_id, Request $request): JsonResponse
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'success' => true,
                'message' => 'Invalid or expired url provided.',
            ], 401);
        }

        $user = User::findOrFail($user_id);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        Auth::login($user);
        $user = Auth::user();

        // to do: send token to email
        return response()->json([
            'success' => true,
            'message' => 'Email confirmed successfully.',
            'data' => [
                'token' => $user->createToken($user->name)->plainTextToken,
                'token_type' => 'Barear',
            ],
        ], 200);
    }

    /**
     * Resend email verification link.
     * 
     * @return JsonResponse
     */
    public function resend(): JsonResponse
    {
        // to do: add $email param for not authed users.
        if (Auth::user()->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Email already verified.',
            ], 400);
        }
        Auth::user()->sendEmailVerificationNotification();
        return response()->json([
            'success' => false,
            'message' => 'Email verification link sent to your email.',
        ], 200);
    }
}
