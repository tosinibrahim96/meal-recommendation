<?php


namespace App\Repositories;


use App\Models\Meal;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class MealRepository
{

    /**Get one meal from the database
     *
     * @param $meal_id
     * @return Meal
     */
    public function getOne($meal_id): Meal
    {
        return Cache::remember(
            "meal-$meal_id",
            86400 ,
                function () use ($meal_id) {
                return Meal::find($meal_id);
            });
    }

    /**Get all meals from the database
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Cache::remember(
            "meals-all",
            86400 ,
            function () {
                return Meal::orderByDesc('created_at')->get();
            });
    }


}
