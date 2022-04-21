<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d';

    /** Get token attribute for a user
     * @return string
     */
    public function getTokenAttribute(): string
    {
        return $this->createToken('access_token')->plainTextToken;
    }

    /**
     * Get all of the allergies for the user.
     */
    public function allergies()
    {
        return $this->morphToMany(Allergy::class, 'allergy_types_morph')
            ->withTimestamps();
    }

    /**
     * Get all of the allergies for the user.
     */
    public function getmealRecommendationsAttribute()
    {
        $user_allergies = $this->allergies()->pluck('id');
        if (count($user_allergies) < 1){
            return Meal::whereHas('items')->get();
        }

         return Meal::whereHas('items')
            ->where(function ($query) use ($user_allergies){
                $query->doesntHave('allergies')
                    ->orwhereHas('allergies', function ($query) use ($user_allergies) {
                        $query->whereNotIn('id', $user_allergies);
                    });
            })->get();
    }

}
