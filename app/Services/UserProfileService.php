<?php


namespace App\Services;


use App\Models\User;

class UserProfileService
{

    protected User $meal;
    protected object $current_data;

    /**
     *  update the details of an existing meal
     *
     * @param array $user_data
     * @return User
     */
    public function update(array $user_data): User
    {
        return User::updateOrcreate(
            ['id' => $user_data['user']],
            $user_data
        );
    }

}
