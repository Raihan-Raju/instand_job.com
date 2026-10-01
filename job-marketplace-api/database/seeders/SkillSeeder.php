<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [

            // Plumbing
            [
                'name' => 'Pipe Fitting',
                'slug' => 'pipe-fitting',
                'description' => 'Pipe fitting and installation work.',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'name' => 'Leak Repair',
                'slug' => 'leak-repair',
                'description' => 'Water pipe and plumbing leak repair.',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'name' => 'Sanitary Installation',
                'slug' => 'sanitary-installation',
                'description' => 'Sanitary fittings and installation.',
                'sort_order' => 3,
                'status' => true,
            ],

            // Electrical
            [
                'name' => 'House Wiring',
                'slug' => 'house-wiring',
                'description' => 'Residential electrical wiring.',
                'sort_order' => 4,
                'status' => true,
            ],
            [
                'name' => 'Switch Installation',
                'slug' => 'switch-installation',
                'description' => 'Electrical switch and socket installation.',
                'sort_order' => 5,
                'status' => true,
            ],
            [
                'name' => 'Electrical Troubleshooting',
                'slug' => 'electrical-troubleshooting',
                'description' => 'Electrical fault detection and repair.',
                'sort_order' => 6,
                'status' => true,
            ],

            // AC Service
            [
                'name' => 'AC Installation',
                'slug' => 'ac-installation',
                'description' => 'Air conditioner installation.',
                'sort_order' => 7,
                'status' => true,
            ],
            [
                'name' => 'AC Servicing',
                'slug' => 'ac-servicing',
                'description' => 'Air conditioner servicing and maintenance.',
                'sort_order' => 8,
                'status' => true,
            ],
            [
                'name' => 'AC Repair',
                'slug' => 'ac-repair',
                'description' => 'Air conditioner fault diagnosis and repair.',
                'sort_order' => 9,
                'status' => true,
            ],

            // Cleaning
            [
                'name' => 'Home Cleaning',
                'slug' => 'home-cleaning',
                'description' => 'Residential home cleaning.',
                'sort_order' => 10,
                'status' => true,
            ],
            [
                'name' => 'Office Cleaning',
                'slug' => 'office-cleaning',
                'description' => 'Office and commercial cleaning.',
                'sort_order' => 11,
                'status' => true,
            ],

            // Painting
            [
                'name' => 'Wall Painting',
                'slug' => 'wall-painting',
                'description' => 'Interior and exterior wall painting.',
                'sort_order' => 12,
                'status' => true,
            ],
            [
                'name' => 'Color Mixing',
                'slug' => 'color-mixing',
                'description' => 'Paint color preparation and mixing.',
                'sort_order' => 13,
                'status' => true,
            ],

            // Carpentry
            [
                'name' => 'Furniture Making',
                'slug' => 'furniture-making',
                'description' => 'Furniture construction and finishing.',
                'sort_order' => 14,
                'status' => true,
            ],
            [
                'name' => 'Furniture Repair',
                'slug' => 'furniture-repair',
                'description' => 'Furniture maintenance and repair.',
                'sort_order' => 15,
                'status' => true,
            ],

            // Driving
            [
                'name' => 'Car Driving',
                'slug' => 'car-driving',
                'description' => 'Private and company car driving.',
                'sort_order' => 16,
                'status' => true,
            ],
            [
                'name' => 'Commercial Driving',
                'slug' => 'commercial-driving',
                'description' => 'Commercial vehicle driving.',
                'sort_order' => 17,
                'status' => true,
            ],

            // Restaurant / Event
            [
                'name' => 'Food Serving',
                'slug' => 'food-serving',
                'description' => 'Restaurant and event food serving.',
                'sort_order' => 18,
                'status' => true,
            ],
            [
                'name' => 'Table Service',
                'slug' => 'table-service',
                'description' => 'Restaurant table service.',
                'sort_order' => 19,
                'status' => true,
            ],

            // Construction / Helper
            [
                'name' => 'Construction Assistance',
                'slug' => 'construction-assistance',
                'description' => 'General construction support work.',
                'sort_order' => 20,
                'status' => true,
            ],
            [
                'name' => 'Material Handling',
                'slug' => 'material-handling',
                'description' => 'Loading, unloading and material handling.',
                'sort_order' => 21,
                'status' => true,
            ],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                [
                    'slug' => $skill['slug'],
                ],
                $skill
            );
        }
    }
}