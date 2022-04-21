<?php


namespace Tests\Feature\Auth;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Successful account creation attempt
     *
     * @return void
     */
    public function test_create_new_useraccount_successful()
    {
        $response = $this->post('/api/v1/register',
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

        $response->assertStatus(201);
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
     * Name must be part of the request
     *
     * @return void
     */
    public function test_create_new_useraccount_name_missing()
    {
        $response = $this->post('/api/v1/register',
            [
                "email" => "testemail@mail.com",
                "password" => "uncommon-password",
                "password_confirmation" => "uncommon-password"
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(422);
        $response->assertJson(
            [
                'errors' => [
                    'first_name' => [
                        'The first name field is required.'
                    ],
                    'last_name' => [
                        'The last name field is required.'
                    ]
                ]
            ]
        );
    }

    /**
     * Email is must be part of the request
     *
     * @return void
     */
    public function test_create_new_useraccount_email_missing()
    {
        $response = $this->post('/api/v1/register',
            [
                "first_name" => "First name",
                "last_name" => "Last name",
                "password" => "uncommon-password",
                "password_confirmation" => "uncommon-password"
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
    public function test_create_new_useraccount_password_missing()
    {
        $response = $this->post('/api/v1/register',
            [
                "first_name" => "First name",
                "last_name" => "Last name",
                "email" => "testemail@mail.com",
                "password_confirmation" => "uncommon-password"
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
     * Confirm password must be part of the request
     *
     * @return void
     */
    public function test_create_new_useraccount_password_confirmation_missing()
    {
        $response = $this->post('/api/v1/register',
            [
                "first_name" => "First name",
                "last_name" => "Last name",
                "email" => "testemail@mail.com",
                "password" => "uncommon-password"
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
                        'The password confirmation does not match.'
                    ]
                ]
            ]
        );
    }



    /**
     * Email must be unique for each account
     *
     * @return void
     */
    public function test_create_new_useraccount_email_mustbe_unique()
    {
        $this->post('/api/v1/register',
            [
                "first_name" => "First name",
                "last_name" => "Last name",
                "email" => "duplicate@gmail.com",
                "password" => "uncommon-password",
                "password_confirmation" => "uncommon-password"
            ],
            [
                "Accept" => "application/json"
            ]
        );
        $response = $this->post('/api/v1/register',
            [
                "first_name" => "First name",
                "last_name" => "Last name",
                "email" => "duplicate@gmail.com",
                "password" => "uncommon-password",
                "password_confirmation" => "uncommon-password"
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
                        'The email has already been taken.'
                    ]
                ]
            ]
        );
    }

}
