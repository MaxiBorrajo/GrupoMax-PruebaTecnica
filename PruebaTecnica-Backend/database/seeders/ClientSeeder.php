<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::factory()->count(149)->create();
        Client::create([
            "first_name" => "Sandra",
            "last_name" => "Sandoval",
            "email" => "sandra@mail.com",
            "age" => 58,
            "phone_number" => "1145788762",
            "status" => "INACTIVE",
            "user_id" => 150
        ]);
    }
}
