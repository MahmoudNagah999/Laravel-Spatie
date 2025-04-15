<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Resources\AuthUserResource;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;

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
            return $this->successResponse(
                AuthUserResource::make($user),
                'User registered successfully',
                201);     
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function login(AuthRequest $request) {
        try{
            $credentials = $request->only('email', 'password');
            $user = $this->authService->login($credentials);
           
            return $this->successResponse(
                AuthUserResource::make($user), 
                'User logged in successfully', 
                200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function user(AuthRequest $request)
    {
        return $this->successResponse(
            AuthUserResource::make($request->user()), 
            'User retrieved successfully', 
            200);
    }

    public function logout(AuthRequest $request)
    {
        $request->user()->tokens()->delete();
        return $this->successResponse(
            [], 
            'Successfully logged out', 
            200);
    }

}
