<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(150)->create();
        User::create([
            'first_name' => 'user',
            'last_name' =>'example',
            'email' => 'example@example.com',
            'password' => 'password1234$',
        ]);
    }
}
