<?php


namespace App\Repositories;


use App\Models\MealItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class MealItemRepository
{

    /**Get one meal item from the database
     *
     * @param $mealitem_id
     * @return MealItem
     */
    public function getOne($mealitem_id): MealItem
    {
         return Cache::remember(
            "meal-item-$mealitem_id",
            86400 ,
            function () use ($mealitem_id) {
            return MealItem::find($mealitem_id);
        });
    }

    /**Get all meal items from the database
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Cache::remember(
            "meal-items-all",
            86400 ,
            function () {
                return MealItem::orderByDesc('created_at')->get();
            });
    }

}
