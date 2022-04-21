<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class UserProfileRepository
{

    /**Get one user from the database
     *
     * @param mixed $user_id
     * @return User
     */
    public function getOne(mixed $user_id): User
    {
        return Cache::remember(
            "user-$user_id",
            86400 ,
            function () use ($user_id) {
                return User::find($user_id);
            });
    }

    /**Get many user records from the database
     *
     * @param array $users_ids
     * @return Collection
     */
    public function getMany(array $users_ids): Collection
    {
        return User::whereIn('id',$users_ids)->get();
    }
}
