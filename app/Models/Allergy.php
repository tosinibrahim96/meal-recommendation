<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d';

    /**
     * Get all of the users for an allergy.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'allergy_types_morph')
            ->withTimestamps();
    }

    /**
     * Get all of the users for an allergy.
     */
    public function meals()
    {
        return $this->morphedByMany(Meal::class, 'allergy_types_morph')
            ->withTimestamps();
    }
}
