<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    protected static $authToken;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        print "\nSETTING UP DATABASE\n";
        shell_exec('php artisan migrate:reset');
        shell_exec('php artisan migrate --seed');
    }
    public function test_login(): void
    {
        $response = $this->post('api/users/login', [
            "email" => "example@example.com",
            "password" => "password1234$"
        ]);

        $response->assertStatus(200);
        self::$authToken = $response->json("token");
    }

    public function test_create_client()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->post('api/clients', [
            "first_name" => "Jorge",
            "last_name" => "Sandoval",
            "email" => "jorge@mail.com",
            "age" => 57,
            "phone_number" => "1145788962",
            "status" => "ACTIVE"
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            "resource" => [
                "id",
                "first_name",
                "last_name",
                "email",
                "age",
                "status",
                "phone_number"
            ]
        ]);
        $response->assertJsonFragment([
            "first_name" => "Jorge",
            "last_name" => "Sandoval",
            "email" => "jorge@mail.com",
            "age" => 57,
            "phone_number" => "1145788962",
            "status" => "ACTIVE"
        ]);
    }

    public function test_request_create_client()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->post('api/clients', [
            "first_name" => "Jorge",
            "last_name" => "Sandoval",
            "email" => "jorge@mail.com",
            "age" => 57,
            "phone_number" => "1145788962",
            "status" => "something"
        ]);

        $response->assertStatus(400);

        $response->assertJsonStructure([
            "error" => [
                "status",
            ]
        ]);
        $response->assertJsonFragment([
            "error" => [
                "status" => ["The selected status is invalid."],
            ]
        ]);
    }

    public function test_update_client()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->put('api/clients/151', [
            "first_name" => "Jorge Ramiro",
            "last_name" => "Sandoval",
            "email" => "jorge@mail.com",
            "age" => 58,
            "phone_number" => "1145788962",
            "status" => "INACTIVE"
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "resource" => [
                "id",
                "first_name",
                "last_name",
                "email",
                "age",
                "status",
                "phone_number"
            ]
        ]);
        $response->assertJsonFragment([
            "first_name" => "Jorge Ramiro",
            "last_name" => "Sandoval",
            "email" => "jorge@mail.com",
            "age" => 58,
            "phone_number" => "1145788962",
            "status" => "INACTIVE"
        ]);
    }

    public function test_request_update_client()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->put('api/clients/151', [
            "status" => "something"
        ]);

        $response->assertStatus(400);

        $response->assertJsonStructure([
            "error" => [
                "status",
            ]
        ]);
        $response->assertJsonFragment([
            "error" => [
                "status" => ["The selected status is invalid."],
            ]
        ]);
    }

    public function test_get_client()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->get('api/clients/151');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "resource" => [
                "id",
                "first_name",
                "last_name",
                "email",
                "age",
                "status",
                "phone_number"
            ]
        ]);
        $response->assertJsonFragment([
            "first_name" => "Jorge Ramiro",
            "last_name" => "Sandoval",
            "email" => "jorge@mail.com",
            "age" => 58,
            "phone_number" => "1145788962",
            "status" => "INACTIVE"
        ]);
    }

    public function test_client_not_found()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->get('api/clients/152');

        $response->assertStatus(400);

        $response->assertJsonStructure([
            "error"
        ]);
        $response->assertJsonFragment([
            "error" => "No results found"
        ]);
    }

    public function test_not_owner_exception()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->get('api/clients/150');

        $response->assertStatus(403);

        $response->assertJsonStructure([
            "error"
        ]);
        $response->assertJsonFragment([
            "error" => "You are not allowed to access this client"
        ]);
    }

    public function test_get_clients()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->get('api/clients?page=2&keyword=a&sort=last_name&order=asc');

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

        $this->assertLessThanOrEqual(150, $response->json('resource')['total']);
        $this->assertEquals(2, $response->json('resource')['current_page']);
    }

    public function test_delete_client()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->delete('api/clients/151');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "message"
        ]);
        $response->assertJsonFragment([
            "message" => "Client deleted successfully"
        ]);
    }

    public function test_client_deleted_not_found()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . self::$authToken])->get('api/clients/151');

        $response->assertStatus(400);

        $response->assertJsonStructure([
            "error"
        ]);
        $response->assertJsonFragment([
            "error" => "No results found"
        ]);
    }

}
