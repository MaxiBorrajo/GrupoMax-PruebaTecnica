<?php

namespace Tests\Feature;

use Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    protected $authToken;
    public function test_register_user(): void
    {
        $response = $this->post('api/users', [
            "first_name"=>"Clara",
            "last_name"=> "Fontevecchia",
            "email"=>"clara@mail.com",
            "password"=>"Clara1234&"
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "resource"=>[
                "id",
                "fullname",
                "email"
            ],
            "token"
        ]);
        $response->assertJsonFragment([
            "fullname" => "Clara Fontevecchia",
            "email" => "clara@mail.com"
        ]);
    }

    public function test_user_already_exists(): void
    {
        $response = $this->post('api/users', [
            "first_name"=>"Clara",
            "last_name"=> "Fontevecchia",
            "email"=>"clara@mail.com",
            "password"=>"Clara1234&"
        ]);

        $response->assertStatus(400);
    }

    public function test_user_request(): void
    {
        $response = $this->post('api/users/login', [
            "last_name"=> "Fontevecchia",
            "email"=>"clara@mail.com",
            "password"=>"Clara1234&"
        ]);

        $response->assertStatus(400);
        $response->assertJsonFragment([
            "error" => [
                "first_name" => ["The first name field is required."]
            ]
        ]);
    }

    public function test_login(): void
    {
        $response = $this->post('api/users/login', [
            "email"=>"clara@mail.com",
            "password"=>"Clara1234&"
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "resource"=>[
                "id",
                "fullname",
                "email"
            ],
            "token"
        ]);
        $response->assertJsonFragment([
            "fullname" => "Clara Fontevecchia",
            "email" => "clara@mail.com"
        ]);

        $this->authToken = $response->token;
    }

    public function test_invalid_credentials(): void
    {
        $response = $this->post('api/users/login', [
            "email"=>"clara@mail.com",
            "password"=>"Clara12345&"
        ]);

        $response->assertStatus(400);

        $response->assertJsonFragment([
            "error" => "Email or password are wrong",
        ]);
    }

    public function test_get_current_user():void{
        $response = $this->get('api/users', [
            "Authorization" => $this->authToken
        ]);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            "error" => "Email or password are wrong",
        ]);
    }
}
