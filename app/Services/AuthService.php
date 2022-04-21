<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    protected User $new_user;

    /**
     * setup new user account
     *
     * @param array $newuser_data
     * @return User
     */
    public function setupUserAccount(array $newuser_data): User
    {
        $this->createNewUser((object)$newuser_data);
        return $this->new_user;
    }


    /**
     * Store a new user in the database
     *
     * @param object $new_user
     * @return void
     *
     */
    private function createNewUser(object $new_user)
    {
        $this->new_user = User::create([
            'first_name' => $new_user->first_name,
            'last_name' => $new_user->last_name,
            'email' => $new_user->email,
            'password' => bcrypt($new_user->password)
        ]);
    }

    /**
     * Grant access to a user with the right credentials
     *
     * @param array $credentials
     * @return object $login_response
     */
    public function login(array $credentials): object
    {
        $login_response = (object)[];
        $login_response->is_successful = Auth::attempt($credentials);

        return $login_response;
    }
}
