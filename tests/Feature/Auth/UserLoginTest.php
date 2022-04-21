<?php


namespace Auth;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLoginTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Successful login attempt
     *
     * @return void
     */
    public function test_user_login_successful()
    {
        $this->post('/api/v1/register',
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
        $response = $this->post('/api/v1/login',
            [
                "email" => "testemail@mail.com",
                "password" => "uncommon-password",
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" =>
                [
                    "user" => [
                        "first_name",
                        "last_name",
                        "email",
                        "created_at"
                    ],
                    "token"
                ]
        ]);
    }

    /**
     * Email is must be part of the request
     *
     * @return void
     */
    public function test_login_email_missing()
    {
        $response = $this->post('/api/v1/login',
            [
                "password" => "password"
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(422);
        $response->assertJson(
            [
                'errors' => [
                    'email' => [
                        'The email field is required.'
                    ]
                ]
            ]
        );
    }


    /**
     * Password must be part of the request
     *
     * @return void
     */
    public function test_login_password_missing()
    {
        $response = $this->post('/api/v1/login',
            [
                "email" => "testemail@mail.com",
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(422);
        $response->assertJson(
            [
                'errors' => [
                    'password' => [
                        'The password field is required.'
                    ]
                ]
            ]
        );
    }


    /**
     * Login attempt with invalid email
     *
     * @return void
     */
    public function test_user_login_invalid_email()
    {
        $this->post('/api/v1/register',
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
        $response = $this->post('/api/v1/login',
            [
                "email" => "testemail1@mail.com",
                "password" => "password",
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(401);
        $response->assertJsonStructure([
            "data",
            "status",
            "message"
        ]);
        $response->assertExactJson([
            "status" => 401,
            "data" => [],
            "message" => "Invalid credentials. Email or Password incorrect"
        ]);
    }



    /**
     * Login attempt with invalid email
     *
     * @return void
     */
    public function test_user_login_invalid_password()
    {
        $this->post('/api/v1/register',
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
        $response = $this->post('/api/v1/login',
            [
                "email" => "testemail@mail.com",
                "password" => "invalid_password",
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(401);
        $response->assertJsonStructure([
            "data",
            "status",
            "message"
        ]);
        $response->assertExactJson([
            "status" => 401,
            "data" => [],
            "message" => "Invalid credentials. Email or Password incorrect"
        ]);
    }

}
