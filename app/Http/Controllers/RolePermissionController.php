<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolePermissionRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    use ApiResponse;

    public function createRole(RolePermissionRequest $request)
    {
        try{
            $data = $request->validated();
            $role = Role::create($data);
    
            return $this->success($role, 'Role created successfully', 201);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    // public function createPermission(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|unique:permissions,name',
    //     ]);

    //     $permission = Permission::create(['name' => $request->name]);

    //     return response()->json([
    //         'message' => 'Permission created successfully',
    //         'permission' => $permission,
    //     ]);
    // }

    // Assign a role to a user
    public function assignRole(RolePermissionRequest $request, $userId)
    {
        try{
            $user = User::findOrFail($userId);
            $user->assignRole($request->role);

            return $this->success($user, 'Role assigned successfully', 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function assignPermissionToRole(RolePermissionRequest $request)
    {
        try{
            $role = Role::findByName($request->role);
            $permission = Permission::findByName($request->permission);

            $role->givePermissionTo($permission);

            return $this->success($role, 'Permission assigned to role successfully', 200); 
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }  
    }

    // Check if a user has a role
    public function checkRole(RolePermissionRequest $request, $userId)
    {
        try{
            $user = User::findOrFail($userId);

            if ($user->hasRole($request->role)) {
                return $this->success($user, 'User has the role', 200);
            }

            return $this->error('User does not have the role', 404);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function checkPermission(Request $request, $userId)
    {
        try{
            $user = User::findOrFail($userId);

            if ($user->can($request->permission)) {
                return $this->success($user, 'User has the permission', 200);
            }

            return $this->error('User does not have the permission', 404);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    
    public function removeRole(RolePermissionRequest $request, $userId)
    {
        try{
            $user = User::findOrFail($userId);
            $user->removeRole($request->role);

            return $this->success($user, 'Role removed successfully', 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function removePermissionFromRole(RolePermissionRequest $request)
    {
        try{
            $role = Role::findByName($request->role);
            $permission = Permission::findByName($request->permission);

            $role->revokePermissionTo($permission);

            return $this->success($role, 'Permission removed from role successfully', 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
