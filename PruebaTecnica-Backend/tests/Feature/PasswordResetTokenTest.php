<?php

namespace Tests\Feature;

use App\Models\PasswordResetToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasswordResetTokenTest extends TestCase
{

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
    }

    public function test_forgot_password(): void
    {
        $response = $this->post('api/users/forgotPassword', [
            "email" => "clara@mail.com"
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "message" => "Email sent. Go to your email account to change your password"
        ]);
    }

    public function test_email_not_found(): void
    {
        $response = $this->post('api/users/forgotPassword', [
            "email" => "clar@mail.com"
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
