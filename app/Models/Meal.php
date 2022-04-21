<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
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
        'main_id'
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d';

    /**
     * Get all of the allergies for the meal.
     */
    public function allergies()
    {
        return $this->morphToMany(Allergy::class, 'allergy_types_morph')
            ->withTimestamps();
    }

    /**
     * The items that belong to the role.
     */
    public function items()
    {
        return $this->belongsToMany(
            MealItem::class,
            'meal_mealitems',
            'meal_id',
            'meal_item_id'
        )->withTimestamps();
    }

    /**
     * The main item for a specific meal.
     */
    public function mainItem()
    {
        return $this->items()
            ->wherePivot('is_main',1);
    }

    /**
     * The side items for a specific meal.
     */
    public function sideItems()
    {
        return $this->items()
            ->wherePivot('is_main','!=',1);
    }

}
