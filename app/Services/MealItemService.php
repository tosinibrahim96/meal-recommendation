<?php


namespace App\Services;


use App\Models\MealItem;
use Illuminate\Support\Facades\Cache;

class MealItemService
{

    /**
     *  Store a new meal item in the database
     *
     * @param array $new_mealitem_data
     * @return MealItem
     */
    public function create(array $new_mealitem_data): MealItem
    {
        $meal_item = MealItem::create($new_mealitem_data);
        Cache::put("meal-item-$meal_item->id",$meal_item);
        Cache::forget("meal-items-all");

        return $meal_item;
    }

    /**
     *  Update details of a meal item in the database
     *
     * @param array $mealitem_data
     * @return MealItem
     */
    public function update($mealitem_data): MealItem
    {
        $meal_item = MealItem::updateOrcreate(
            ['id' => $mealitem_data['meal_item']],
            $mealitem_data
        );
        Cache::put("meal-item-$meal_item->id",$meal_item);

        return $meal_item;
    }

    /**
     *  Delete a meal item from the database
     *
     * @param mixed $mealitem_id
     * @return void
     */
    public function delete(mixed $mealitem_id): void
    {
       MealItem::destroy($mealitem_id);
       Cache::forget("meal-item-$mealitem_id");
    }


}
