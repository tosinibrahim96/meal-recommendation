<?php


namespace App\Http\Requests\MealRequests;


use App\Http\ApiRequest;

class GetOneMealRequest extends ApiRequest
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
            'meal' => 'required|numeric|exists:meals,id',
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
            'meal.exists' => 'Invalid meal found in request',
            'meal.numeric' => 'Invalid meal found in request'
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
            'meal' => $this->id
        ]);
    }


}
