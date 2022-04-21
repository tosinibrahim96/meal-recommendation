<?php


namespace App\Http\Requests\Auth;

use App\Http\ApiRequest;

class RegisterUserRequest extends ApiRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|max:255|email|unique:users',
            'password' => 'required|min:6|dumbpwd|confirmed',
            'allergies' => 'array',
            'allergies.*' => 'exists:allergies,id',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'allergies.*.exists' => "The selected allergy is invalid",
            'password.dumbpwd' => "This password is too common. Please use a more secure password."
        ];
    }
}
