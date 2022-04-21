<?php


namespace App\Http\Requests\UserProfileRequests;


use App\Http\ApiRequest;

class UpdateUserProfileRequest extends ApiRequest
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
            'user' => 'required|numeric|exists:users,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|max:255|email|unique:users,email,'.$this->user,
            'allergies' => 'nullable|array',
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
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user' =>$this->id,
            'allergies' => is_array($this->allergies) ?
                array_unique($this->allergies):$this->allergies,
        ]);

    }
}
