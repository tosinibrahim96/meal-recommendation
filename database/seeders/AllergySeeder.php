<?php

namespace Database\Seeders;

use App\Models\Allergy;
use Illuminate\Database\Seeder;

class AllergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allergies = [
            [
                'name' => 'Nut Allergy',
                'description' => 'Description for nut allergy',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Shellfish Allergy',
                'description' => 'Description for shellfish allergy',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'SeaFood  Allergy',
                'description' => 'Description for seafood allergy',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Allergy::insert($allergies);
    }
}
