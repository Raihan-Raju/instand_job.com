<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BangladeshLocationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            /*
            |--------------------------------------------------------------------------
            | Dhaka Division
            |--------------------------------------------------------------------------
            */

            $dhakaDivision = Division::updateOrCreate(
                [
                    'code' => 'DHAKA',
                ],
                [
                    'name_en' => 'Dhaka',
                    'name_bn' => 'ঢাকা',
                    'status' => 1,
                    'sort_order' => 1,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Dhaka District
            |--------------------------------------------------------------------------
            */

            $dhakaDistrict = District::updateOrCreate(
                [
                    'code' => 'DHAKA-DIST',
                ],
                [
                    'division_id' => $dhakaDivision->id,
                    'name_en' => 'Dhaka',
                    'name_bn' => 'ঢাকা',
                    'status' => 1,
                    'sort_order' => 1,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Sample Thana / Upazila
            |--------------------------------------------------------------------------
            */

            Upazila::updateOrCreate(
                [
                    'code' => 'MIRPUR',
                ],
                [
                    'district_id' => $dhakaDistrict->id,
                    'name_en' => 'Mirpur',
                    'name_bn' => 'মিরপুর',
                    'type' => 'thana',
                    'status' => 1,
                    'sort_order' => 1,
                ]
            );


            Upazila::updateOrCreate(
                [
                    'code' => 'UTTARA',
                ],
                [
                    'district_id' => $dhakaDistrict->id,
                    'name_en' => 'Uttara',
                    'name_bn' => 'উত্তরা',
                    'type' => 'thana',
                    'status' => 1,
                    'sort_order' => 2,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Chattogram Division
            |--------------------------------------------------------------------------
            */

            $chattogramDivision = Division::updateOrCreate(
                [
                    'code' => 'CHATTOGRAM',
                ],
                [
                    'name_en' => 'Chattogram',
                    'name_bn' => 'চট্টগ্রাম',
                    'status' => 1,
                    'sort_order' => 2,
                ]
            );


            $chattogramDistrict = District::updateOrCreate(
                [
                    'code' => 'CHATTOGRAM-DIST',
                ],
                [
                    'division_id' => $chattogramDivision->id,
                    'name_en' => 'Chattogram',
                    'name_bn' => 'চট্টগ্রাম',
                    'status' => 1,
                    'sort_order' => 1,
                ]
            );


            Upazila::updateOrCreate(
                [
                    'code' => 'PATIYA',
                ],
                [
                    'district_id' => $chattogramDistrict->id,
                    'name_en' => 'Patiya',
                    'name_bn' => 'পটিয়া',
                    'type' => 'upazila',
                    'status' => 1,
                    'sort_order' => 1,
                ]
            );
        });
    }
}