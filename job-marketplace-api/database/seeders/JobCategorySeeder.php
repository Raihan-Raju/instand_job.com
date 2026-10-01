<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Plumbing',
                'slug' => 'plumbing',
                'description' => 'Plumbing and pipe fitting services.',
                'icon' => null,
                'parent_id' => null,
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'name' => 'Electrical',
                'slug' => 'electrical',
                'description' => 'Electrical installation and repair services.',
                'icon' => null,
                'parent_id' => null,
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'name' => 'AC Service',
                'slug' => 'ac-service',
                'description' => 'Air conditioner installation, servicing and repair.',
                'icon' => null,
                'parent_id' => null,
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'name' => 'Cleaning',
                'slug' => 'cleaning',
                'description' => 'Home, office and general cleaning services.',
                'icon' => null,
                'parent_id' => null,
                'sort_order' => 4,
                'status' => true,
            ],
            [
                'name' => 'Painting',
                'slug' => 'painting',
                'description' => 'Home, office and building painting services.',
                'icon' => null,
                'parent_id' => null,
                'sort_order' => 5,
                'status' => true,
            ],
            [
                'name' => 'Carpentry',
                'slug' => 'carpentry',
                'description' => 'Furniture and carpentry services.',
                'icon' => null,
                'parent_id' => null,
                'sort_order' => 6,
                'status' => true,
            ],
            [
                'name' => 'Driver',
                'slug' => 'driver',
                'description' => 'Personal, company and temporary driving services.',
                'icon' => null,
                'parent_id' => null,
                'sort_order' => 7,
                'status' => true,
            ],
            [
                'name' => 'Waiter',
                'slug' => 'waiter',
                'description' => 'Restaurant, event and temporary waiter services.',
                'icon' => null,
                'parent_id' => null,
                'sort_order' => 8,
                'status' => true,
            ],
            [
                'name' => 'Helper',
                'slug' => 'helper',
                'description' => 'General helper and support services.',
                'icon' => null,
                'parent_id' => null,
                'sort_order' => 9,
                'status' => true,
            ],
            [
                'name' => 'Construction Worker',
                'slug' => 'construction-worker',
                'description' => 'Construction and general building work.',
                'icon' => null,
                'parent_id' => null,
                'sort_order' => 10,
                'status' => true,
            ],
        ];

        foreach ($categories as $category) {
            JobCategory::updateOrCreate(
                [
                    'slug' => $category['slug'],
                ],
                $category
            );
        }
    }
}