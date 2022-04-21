<?php


namespace App\Http\Requests\MealItemRequests;


use App\Http\ApiRequest;

class GetOneMealItemRequest extends ApiRequest
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
            'meal_item' => 'required|numeric|exists:meal_items,id',
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
            'meal_item.exists' => 'Invalid meal item found in request',
            'meal_item.numeric' => 'Invalid meal item found in request'
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
            'meal_item' => $this->id
        ]);
    }

}
