<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            User::factory()->create([
                'name' => 'Zahit Egemen İm',
                "username" => 11111111111,
                'password' => bcrypt('123'),
                'email' => "zegemenim@"
            ])
        ]);
    }
}
