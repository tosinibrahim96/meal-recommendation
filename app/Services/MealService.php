<?php


namespace App\Services;


use App\Models\Meal;
use App\Models\MealMealItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MealService
{

    protected Meal $meal;
    protected object $current_data;


    /**
     *  Store a new meal in the database
     *
     * @param array $newmeal_data
     * @return Meal
     */
    public function create(array $newmeal_data): Meal
    {
        $meal = Meal::create($newmeal_data);
        Cache::put("meal-$meal->id",$meal);
        Cache::forget("meals-all");

        return $meal;
    }

    /**
     *  Update the details of an existing meal
     *
     * @param array $meal_data
     * @return Meal
     */
    public function update(array $meal_data): Meal
    {
        $meal = Meal::updateOrcreate(
            ['id' => $meal_data['meal']],
            $meal_data
        );
        Cache::put("meal-$meal->id",$meal);

        return $meal;
    }

    /**
     *  Delete a meal from the database
     *
     * @param mixed $meal_id
     * @return void
     */
    public function delete(mixed $meal_id): void
    {
        Meal::destroy($meal_id);
        DB::table('allergy_types_morphs')
            ->where('allergy_types_morph_type',MEAL::class)
            ->where('allergy_types_morph_id',$meal_id)
            ->delete();
        Cache::forget("meal-$meal_id");
    }


    /** Create a database relationship between a meal
     * and all meal items attached to that meal
     *
     * @param Meal $meal
     * @param array $data
     * @return void
     */
    public function syncMealItems(Meal $meal, array $data): void
    {
        $this->meal = $meal;
        $this->current_data = (object)$data;

        if (array_key_exists('side_items', $data) &&
            array_key_exists('main_item', $data)
        ) {
            $this->syncAllMealItems();
            $this->SetMainMealItem();
        }
    }

    /**
     * Detach and attach new meal items for a
     * meal
     *
     * @return void
     */
    private function syncAllMealItems(): void
    {
        $all_items = array_merge(
            $this->current_data->side_items,
            [$this->current_data->main_item]
        );

        $this->meal->items()->detach();
        $this->meal->items()->attach($all_items);
    }

    /**
     * Set the main item of the meal after completing the
     * meal-mealitem relationship
     *
     * @return void
     */
    private function SetMainMealItem(): void
    {
        MealMealItem::updateOrCreate([
            'meal_id' => $this->meal->id,
            'meal_item_id' => $this->current_data->main_item
        ],
        [
            'is_main' => 1
        ]);
    }


}
