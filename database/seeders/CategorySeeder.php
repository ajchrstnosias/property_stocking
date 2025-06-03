<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and components such as computers, monitors, printers, projectors, etc.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Furniture',
                'description' => 'Items of furniture such as desks, chairs, tables, cabinets, shelves, etc.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Office Supplies',
                'description' => 'Consumable items used in an office, like stationery, paper, toners, etc.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Equipment',
                'description' => 'Specialized equipment for various departments or purposes (e.g., lab equipment, sports equipment).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vehicles',
                'description' => 'University-owned vehicles such as cars, vans, or utility vehicles.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Books & Library Materials',
                'description' => 'Books, journals, and other library resources.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tools & Machinery',
                'description' => 'Tools and machinery for maintenance, workshops, etc.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data, checking for uniqueness on 'name'
        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }

        // If you prefer raw DB insert and have many records and don't need Eloquent events:
        // DB::table('categories')->insert($categories);
        // Note: When using DB::table()->insert(), manually handle created_at/updated_at if not handled by DB default.
        // And updateOrCreate is generally safer for repeated seeding.
    }
} 