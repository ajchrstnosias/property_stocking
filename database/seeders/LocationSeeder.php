<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to allow truncate if there are related records
        // Adjust for your specific database if not MySQL
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 
        Location::truncate(); // Deletes all records from the locations table
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $locations = [
            [
                'name' => 'Academic Building 1',
                'description' => 'Houses various classrooms and lecture halls.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'name' => 'Academic Building 2',
            //     'description' => 'Houses various classrooms and lecture halls.',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'name' => 'Academic Building 2 Extension',
            //     'description' => 'Extension of Academic Building 2, housing additional classrooms and lecture halls.',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            [
                'name' => 'Engineering Building 1',
                'description' => 'Accommodates the College of Engineering and Architecture, providing specialized spaces for engineering disciplines.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'name' => 'Engineering Building 2',
            //     'description' => 'Accommodates the College of Engineering and Architecture, providing specialized spaces for engineering disciplines.',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'name' => 'Engineering Building 3',
            //     'description' => 'Accommodates the College of Engineering and Architecture, providing specialized spaces for engineering disciplines.',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            [
                'name' => 'College of Arts and Education Building',
                'description' => 'Dedicated to the College of Arts and Education, supporting programs in education and general studies.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'School of Advanced Studies Building',
                'description' => 'Facility catering to graduate programs, offering advanced academic resources for postgraduate students.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pangasinan Technology Business Incubator (PTBI) Center',
                'description' => 'A hub for innovation and entrepreneurship, supporting startups and business development initiatives.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Student Activity Center',
                'description' => 'A venue for student organizations and extracurricular activities.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Campus Amphitheater',
                'description' => 'An open-air space for events, performances, and assemblies.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Library',
                'description' => 'Offers a wide range of academic resources, including books, theses, and electronic materials.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Clinic',
                'description' => 'Provides medical and dental services to students and staff.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cafeteria',
                'description' => 'Essential services offering meals',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        foreach ($locations as $location) {
            Location::create($location);
        }
    }
} 