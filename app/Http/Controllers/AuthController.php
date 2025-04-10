<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    protected AuthService $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function register(AuthRequest $request) {
        try{
            $user = $this->authService->register($request->validated());
            return $this->success($user, 'User registered successfully', 201);     
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function login(AuthRequest $request) {
        try{
            $credentials = $request->only('email', 'password');
            $user = $this->authService->login($credentials);
           
            return $this->success($user, 'User logged in successfully', 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function user(AuthRequest $request)
    {
        return $this->success($request->user(), 'User retrieved successfully', 200);
    }

    public function logout(AuthRequest $request)
    {
        $request->user()->tokens()->delete();
        return $this->success([], 'Successfully logged out', 200);
    }

}
