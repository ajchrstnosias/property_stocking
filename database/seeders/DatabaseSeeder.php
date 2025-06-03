<?php

namespace Database\Seeders;

// use App\Models\User; // Commented out or remove if not creating other test users here
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create(); // Example default

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]); // Example default

        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,
            LocationSeeder::class,
            // You can add other seeders here as you create them, for example:
            // CategorySeeder::class,
            // LocationSeeder::class,
            // ItemSeeder::class,
        ]);
    }
}
