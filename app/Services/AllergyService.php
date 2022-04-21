<?php


namespace App\Services;


use App\Models\Meal;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AllergyService
{
    protected object $current_data;

    /**Create a relationship in the DB between a user
     * and a set of allergies
     *
     * @param User $user
     * @param array $data
     */
    public function syncUserAllergies(User $user, array $data)
    {
        $this->current_data = (object)$data;
        $this->syncModelWithAllergies($user);
    }

    /**Create a relationship in the DB between a meal
     * and a set of allergies
     *
     * @param Meal $meal
     * @param array $data
     */
    public function syncMealAllergies(Meal $meal, array $data)
    {
        $this->current_data = (object)$data;
        $this->syncModelWithAllergies($meal);
    }

    /** Save the allergies associated to a particular type
     * (User or Meal)
     *
     * @param Model $model
     */
    private function syncModelWithAllergies(Model $model)
    {
        if(isset($this->current_data->allergies)){
            $model->allergies()->sync($this->current_data->allergies);
        }
    }


}
