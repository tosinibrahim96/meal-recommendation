<?php


namespace App\Http\Requests\MealRequests;


use App\Http\ApiRequest;

class UpdateMealRequest extends ApiRequest
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
            'name' => 'required|string|max:255|unique:meals,name,'.$this->meal,
            'description' => 'string|max:255',
            'main_item' => [
                'required_with:side_items',
                'exists:meal_items,id',
                function ($attribute, $value, $fail) {
                    if(is_array($this->side_items) && in_array($value,$this->side_items)){
                        $fail('The main item cannot be one of the side items in the same meal.');
                    }
                },
            ],
            'side_items' => 'nullable|required_with:main_item|array|min:2',
            'side_items.*' => 'exists:meal_items,id',
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
            'meal' =>$this->id,
            'allergies' => is_array($this->allergies) ?
                array_unique($this->allergies):$this->allergies,
            'side_items' => is_array($this->side_items) ?
                array_unique($this->side_items):$this->side_items,

        ]);

    }

}
