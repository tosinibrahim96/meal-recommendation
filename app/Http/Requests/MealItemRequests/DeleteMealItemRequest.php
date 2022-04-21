<?php


namespace App\Http\Requests\MealItemRequests;


use App\Http\ApiRequest;
use App\Models\MealItem;

class DeleteMealItemRequest extends ApiRequest
{
    protected  $meal_item;

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
            'meal_item' => [
                'required','numeric',
                'exists:meal_items,id',
                function ($attribute, $value, $fail) {

                    if (isset($this->meal_item)){
                        if($this->meal_item->isAMainItem()){
                            $fail('Meal item cannot be deleted. It is a main item in one or more meals.');
                        }

                        if ($this->meal_item->belongsToMealWithMinimumSideItems()){
                            $minimum_mealitems_per_meal = 2;
                            $fail("Meal item cannot be deleted. It is a side item for a meal with only $minimum_mealitems_per_meal side items");
                        }
                    }
                },
            ]
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
        $this->meal_item = MealItem::find($this->id);
        $this->merge([
            'meal_item' => $this->id
        ]);
    }

}
