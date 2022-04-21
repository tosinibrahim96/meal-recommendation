<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MealItem extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d';

    /**
     * Determine if a meal item should be deletable
     * This is based on whether it's in use as a main item for a meal
     *
     * @return bool
     */
    public function isAMainItem(): bool
    {
        return MealMealItem::where('meal_item_id', $this->id)
            ->where('is_main',1)
            ->count() > 0;
    }


    /**
     * Determine if a meal item should be deletable
     * This is based on whether it's in use as a side item for a meal
     * that has only the minimum number of side items
     *
     */
    public function belongsToMealWithMinimumSideItems()
    {
        $minimum_required_sideitems = 2;
        $grouped_side_items = DB::table('meal_mealitems')
            ->where('is_main', 0)
            ->get()
            ->groupBy('meal_id');

        foreach ($grouped_side_items as $side_items){
            if ($side_items->where('meal_item_id', $this->id)->count() > 0
            && count($side_items) <= $minimum_required_sideitems
            ){
                return true;
            }
        }

        return false;
    }
}
