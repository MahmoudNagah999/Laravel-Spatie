<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
        return match($this->route()->getActionMethod()) {
            'store' => [
                'name' => 'required|string|max:255|unique:teams',
                'description' => 'nullable|string',
            ],
            'update' => [
                'name' => 'required|string|max:255|unique:teams,name,' . $this->route('team')->id,
                'description' => 'nullable|string',
            ],
            default => [],
        };
    }
}
