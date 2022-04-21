<?php


namespace App\Repositories;


use App\Models\Allergy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class AllergyRepository
{

    /**Get all allergies from the database
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Cache::rememberForever(
            "allergies-all",
            function (){
                return Allergy::all();
            });
    }

}
