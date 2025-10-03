<?php

namespace App\Infrastructure\Http\Controllers\Api;

// UseCases
use App\Application\UseCases\Auth\LoginUser;
use App\Application\UseCases\Auth\RegisterUser;
use App\Application\UseCases\Auth\LogoutUser;

// Requests
use Illuminate\Http\Request;
use App\Infrastructure\Http\Requests\RegisterRequest;
use App\Infrastructure\Http\Requests\LoginRequest;

// Responses
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    public function __construct(
        private RegisterUser $registerUser,
        private LoginUser $loginUser,
        private LogoutUser $logoutUser
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->registerUser->execute($request->validated());

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'email' => $user->email,
                ],
                'token' => $token,
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = $this->loginUser->execute(
                $request->email,
                $request->password
            );
            
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'email' => $user->email,
                ],
                'token' => $token,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(Request $request): Response
    {
        $user = $request->user();
        $token = $user->currentAccessToken();

        if (!$token) {
            return response()->json(['message' => 'No token found'], Response::HTTP_UNAUTHORIZED);
        }

        $this->logoutUser->fromCurrentToken($user->id, $token->id);

        return response()->noContent();
    }
}
