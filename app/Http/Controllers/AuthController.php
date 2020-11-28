<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->authService->login($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function me()
    {
        return response()->json($this->authService->getUser());
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function signUp(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            Validator::make($credentials, [
                'email' => 'required|email',
                'password' => 'required|min:6'
            ], [
                'email' => 'wrong email format'
            ])->validate();
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!User::where(['email' => $credentials['email']])->first()) {
            User::create([
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password'])
            ]);

            if ($token = $this->authService->login($credentials)) {
                return $this->respondWithToken($token);
            }

            return response()->json(['errors' => 'Unhandled server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['errors' => ['email' => 'Email is already used']], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->authService->getTTL()
        ]);
    }
}
