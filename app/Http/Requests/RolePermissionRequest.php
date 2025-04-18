<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return match ($this->route()->getActionMethod()) {
            'createRole' => [
                'name' => 'required|string|unique:roles,name',
            ],
            'assignRole' => [
                'role' => 'required|string|exists:roles,name',
            ],
            'assignPermissionToRole' => [
                'role' => 'required|string|exists:roles,name',
                'permission' => 'required|string|exists:permissions,name',
            ],
            'removeRole' => [
                'role' => 'required|string|exists:roles,name',
            ],
            'removePermissionFromRole'=> [
                'role' => 'required|string|exists:roles,name',
                'permission' => 'required|string|exists:permissions,name',
            ],
            default => [],
        };
    }
}
