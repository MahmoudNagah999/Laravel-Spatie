<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Traits\ApiResponse;

class UserController extends Controller
{

    use ApiResponse;

    protected UserService $userService;
   
    public function __construct( UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function index(UserRequest $request)
    {
        try {
            $users = $this->userService->paginate();
            return $this->paginatedResponse(
                UserResource::collection($users), 
                'Users retrieved successfully', 
                200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function store(UserRequest $request)
    {
        try {
            $user = $this->userService->create($request->validated());
            return $this->successResponse(
                UserResource::make($user), 
                'User created successfully', 
                201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage() , 500);
        }
    }

    public function show($id)
    {
        try{
            $user = $this->userService->find($id);
            return $this->successResponse(
                UserResource::make($user), 
                'User retrieved successfully', 
                200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function update(UserRequest $request, $id)
    {
        try{  
            $user = $this->userService->update($id, $request->validated());
            return $this->successResponse(
                UserResource::make($user), 
                'User updated successfully', 
                200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->delete($id);
            return $this->successResponse(
                [], 
                'User deleted successfully', 
                200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function toggleStatus(int $id)
    {
        $this->userService->toggleStatus($id);
        return $this->successResponse([], 'User status updated successfully', 200);
    }

    public function resetPassword(UserRequest $request, $id)
    {
        try {
            $user = $this->userService->find($id);
            $data['password'] = bcrypt($request->input('password'));
            $this->userService->update($id, $data);

            $user->tokens()->delete();
            return $this->successResponse(
                UserResource::make($user), 
                'User password updated successfully', 
                200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }
}
