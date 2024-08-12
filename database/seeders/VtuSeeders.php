<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VtuSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
           
            AirtimeTopupSeeder::class,
            DataPlansSeeder::class,
            CablePlansSeeder::class,
            RouterPlansSeeder::class,
            EducationalPlanSeeder::class,
        ]);
    }
}
