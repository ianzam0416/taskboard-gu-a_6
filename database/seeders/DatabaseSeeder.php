<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'ana@example.com'],
            [
                'name' => 'Ana',
                'password' => 'password123',
            ]
        );

        User::firstOrCreate(
            ['email' => 'carlos@example.com'],
            [
                'name' => 'Carlos',
                'password' => 'password123',
            ]
        );

        $this->call([
            ComercioSeeder::class,
        ]);
    }
}
