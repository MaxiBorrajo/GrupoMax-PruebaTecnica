<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected static $authToken;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        print "\nSETTING UP DATABASE\n";
        shell_exec('php artisan migrate:reset');
        shell_exec('php artisan migrate --seed');
    }
    public function test_register_user(): void
    {
        $response = $this->post('api/users', [
            "first_name" => "Clara",
            "last_name" => "Fontevecchia",
            "email" => "clara@mail.com",
            "password" => "Clara1234&"
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            "resource" => [
                "id",
                "first_name",
                "last_name",
                "email"
            ],
            "token"
        ]);
        $response->assertJsonFragment([
            "first_name" => "Clara",
            "last_name" => "Fontevecchia",
            "email" => "clara@mail.com"
        ]);
    }

    public function test_user_already_exists(): void
    {
        $response = $this->post('api/users', [
            "first_name" => "Clara",
            "last_name" => "Fontevecchia",
            "email" => "clara@mail.com",
            "password" => "Clara1234&"
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            "error" => ["email"]
        ]);
    }

    public function test_user_request(): void
    {
        $response = $this->post('api/users', [
            "email" => "clara@mail.com",
            "password" => "Clara1234&"
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            "error" => [
                "first_name",
                "last_name",
                "email"
            ]
        ]);
    }

    public function test_login(): void
    {
        $response = $this->post('api/users/login', [
            "email" => "clara@mail.com",
            "password" => "Clara1234&"
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "resource" => [
                "id",
                "first_name",
                "last_name",
                "email"
            ],
            "token"
        ]);
        $response->assertJsonFragment([
            "first_name" => "Clara",
            "last_name" => "Fontevecchia",
            "email" => "clara@mail.com"
        ]);
        self::$authToken = $response->json("token");
    }

    public function test_invalid_credentials(): void
    {
        $response = $this->post('api/users/login', [
            "email" => "clara@mail.com",
            "password" => "Clara12345&"
        ]);

        $response->assertStatus(400);

        $response->assertJsonFragment([
            "error" => "Email or password are wrong",
        ]);
    }

    public function test_get_current_user(): void
    {
        $this->assertNotEmpty(self::$authToken, 'El token de autorización no puede estar vacío');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->get('api/users/current');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "resource" => [
                "id",
                "first_name",
                "last_name",
                "email"
            ]
        ]);
        $response->assertJsonFragment([
            "first_name" => "Clara",
            "last_name" => "Fontevecchia",
            "email" => "clara@mail.com"
        ]);
    }

    public function test_invalid_authorization(): void
    {
        $response = $this->get('api/users/current');

        $response->assertStatus(401);

        $response->assertJsonStructure([
            "error"
        ]);

        $response->assertJsonFragment([
            "error" => "Invalid authorization/authentication",
        ]);
    }

    public function test_update_user(): void
    {
        $this->assertNotEmpty(self::$authToken, 'El token de autorización no puede estar vacío');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->put('api/users',
            [
                'first_name' => 'Clara Melina'
            ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "resource" => [
                "id",
                "first_name",
                "last_name",
                "email"
            ]
        ]);
        $response->assertJsonFragment([
            "first_name" => "Clara Melina",
            "last_name" => "Fontevecchia",
            "email" => "clara@mail.com"
        ]);
    }


    public function test_request_update_user(): void
    {
        $this->assertNotEmpty(self::$authToken, 'El token de autorización no puede estar vacío');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->put('api/users',
            [
                'email' => 'Clara'
            ]);

        $response->assertStatus(400);

        $response->assertJsonStructure([
            "error" => [
                "email"
            ]
        ]);
    }

    public function test_email_already_taken_exception(): void
    {
        $this->assertNotEmpty(self::$authToken, 'El token de autorización no puede estar vacío');
        $this->post('api/users', [
            "first_name" => "Jason",
            "last_name" => "Fontevecchia",
            "email" => "jason@mail.com",
            "password" => "Jason1234&"
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->put('api/users',
            [
                'email' => 'jason@mail.com'
            ]);

        $response->assertStatus(400);

        $response->assertJsonStructure([
            "error"
        ]);

        $response->assertJsonFragment([
            "error" => "Email already taken"
        ]);
    }

    public function test_get_users(): void
    {
        $this->assertNotEmpty(self::$authToken, 'El token de autorización no puede estar vacío');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->get('api/users?page=1&keyword=ma&sort=last_name&order=asc');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "resource" => [
                "current_page",
                "data",
                "first_page_url",
                "from",
                "last_page",
                "last_page_url",
                "links",
                "next_page_url",
                "path",
                "prev_page_url",
                "to",
                "total"
            ]
        ]);
        assert($response->json("next_page_url")->total === "http://127.0.0.1:8000/api/users?keyword=ma&sort=last_name&order=asc&page=2");
        assert($response->json("prev_page_url")->total === null);
        assert($response->json("resource")->total === 37);
    }

    public function test_pagination(): void
    {
        $this->assertNotEmpty(self::$authToken, 'El token de autorización no puede estar vacío');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->get('api/users?page=2&keyword=ma&sort=last_name&order=asc');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "resource" => [
                "current_page",
                "data",
                "first_page_url",
                "from",
                "last_page",
                "last_page_url",
                "links",
                "next_page_url",
                "path",
                "prev_page_url",
                "to",
                "total"
            ]
        ]);
        assert($response->json("next_page_url")->total === null);
        assert($response->json("prev_page_url")->total === "http://127.0.0.1:8000/api/users?keyword=ma&sort=last_name&order=asc&page=1");
        assert($response->json("resource")->total === 37);
    }

    public function test_logout(): void
    {
        $this->assertNotEmpty(self::$authToken, 'El token de autorización no puede estar vacío');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->delete('api/users/logout');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "message"
        ]);

        $response->assertJsonFragment([
            "message" => "Logged out successfully",
        ]);
    }

    public function test_fail_auth_after_logout(): void
    {
        $this->assertNotEmpty(self::$authToken, 'El token de autorización no puede estar vacío');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->get('api/users/current');

        $response->assertStatus(401);

        $response->assertJsonStructure(["error"]);

        $response->assertJsonFragment([
            "error" => "Invalid authorization/authentication"
        ]);
    }

    public function test_delete_user(): void
    {
        $login = $this->post('api/users/login', [
            "email" => "clara@mail.com",
            "password" => "Clara1234&"
        ]);


        self::$authToken = $login->json("token");

        $this->assertNotEmpty(self::$authToken, 'El token de autorización no puede estar vacío');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->delete('api/users/');

        $response->assertStatus(200);

        $response->assertJsonStructure(["message"]);

        $response->assertJsonFragment([
            "message" => "User deleted successfully"
        ]);
    }

    public function test_user_not_found_after_elimination(): void
    {
        $response = $this->post('api/users/login', [
            "email" => "clara@mail.com",
            "password" => "Clara1234&"
        ]);

        $response->assertStatus(400);

        $response->assertJsonStructure([
            "error" => ["email"],
        ]);

        $response->assertJsonFragment([
            "error" => ["email" => ["The selected email is invalid."]],
        ]);
    }
}
