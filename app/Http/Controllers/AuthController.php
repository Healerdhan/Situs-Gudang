<?php

namespace App\Http\Controllers;

use App\Exceptions\Error;
use App\Services\User\Dto\CreateUserDto;
use App\Services\User\Interfaces\UserRepositoryInterface;
use App\Services\User\Interfaces\UserServiceInterface;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $userService;

    public function __construct(UserRepositoryInterface $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $hashedPassword = Hash::make($request->password);

            $createUserDto = new CreateUserDto(
                $request->name,
                $request->email,
                $hashedPassword
            );

            $user = $this->userService->createUser($createUserDto);

            return response()->json([
                'success' => true,
                'code' => 201,
                'message' => 'User registered successfully',
                'data' => $user
            ], 201);
        } catch (Error | \Exception $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'code' => 401,
                    'message' => 'Invalid credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Could not create token'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Login successful',
            'data' => [
                'token' => $token
            ]
        ]);
    }


    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Logged out successfully'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Could not log out'
            ], 500);
        }
    }


    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $request->user()
        ]);
    }
}
