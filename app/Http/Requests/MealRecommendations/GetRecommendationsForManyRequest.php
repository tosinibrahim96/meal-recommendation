<?php


namespace App\Http\Requests\MealRecommendations;


use App\Http\ApiRequest;

class GetRecommendationsForManyRequest extends ApiRequest
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
            'users' => 'required|array|min:1',
            'users.*' => 'numeric|exists:users,id',
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
            'users.*.exists' => 'Invalid user found in request',
            'users.*.numeric' => 'Invalid user found in request'
        ];
    }
}
