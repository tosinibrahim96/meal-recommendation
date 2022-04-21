<?php


namespace Auth;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLogoutTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Successful logout attempt
     *
     * @return void
     */
    public function test_user_logout_successful()
    {
        $register_response = $this->post('/api/v1/register',
            [
                "first_name" => "First name",
                "last_name" => "Last name",
                "email" => "testemail@mail.com",
                "password" => "uncommon-password",
                "password_confirmation" => "uncommon-password"
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $token = json_decode($register_response->getContent())->data->token;
        $logout_response = $this->post('/api/v1/logout',
            [],
            [
                "Accept" => "application/json",
                "Authorization" => "Bearer $token"
            ]
        );
        $logout_response->assertStatus(200);
        $logout_response->assertExactJson([
            "status" => 200,
            "data" => [],
            "message" => "Logout successful."
        ]);
    }


    /**
     * Logout attempt without valid token
     *
     * @return void
     */
    public function test_user_logout_unauthorized()
    {
        $logout_response = $this->post('/api/v1/logout',
            [],
            [
                "Accept" => "application/json",
            ]
        );
        $logout_response->assertStatus(401);
        $logout_response->assertExactJson([
            "status" => 401,
            "data" => "Unauthorized",
            "message" => "Access denied. You are currently not authorized to use this system function."
        ]);
    }
}
