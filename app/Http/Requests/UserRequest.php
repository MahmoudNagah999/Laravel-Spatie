<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
       return match($this->route()->getActionMethod()){
            'store' => [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|same:password',
            ],
            'update' => [
                'name' => 'string|max:255',
                'email' => 'email|unique:users,email,' . $this->route('user'),
                'password' => 'nullable|string|min:8',
            ],
            'resetPassword' => [
                'password' => 'required|string|min:8',
            ],
            default => [],

       };
    }
}
