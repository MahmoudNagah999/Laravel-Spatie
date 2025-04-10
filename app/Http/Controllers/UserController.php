<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

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
            return $this->paginated($users, 'Users retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function store(UserRequest $request)
    {
        try {
            $user = $this->userService->create($request->validated());
            return $this->success($user, 'User created successfully', 201);
        } catch (\Exception $e) {
            return $this->error($e->getMessage() , 500);
        }
    }

    public function show($id)
    {
        try{
            $user = $this->userService->find($id);
            return $this->success($user, 'User retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    public function update(UserRequest $request, $id)
    {
        try{  
            $user = $this->userService->update($id, $request->validated());
            return $this->success($user, 'User updated successfully', 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->delete($id);
            return $this->success([], 'User deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }
}
