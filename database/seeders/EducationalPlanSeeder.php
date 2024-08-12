<?php

namespace Database\Seeders;

use App\Functions\UsefulFunctions;
use App\Models\EducationalPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationalPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $functions = new UsefulFunctions();
        $networks = ['waec', 'neco'];

        for ($i = 0; $i < count($networks); $i++) {
            $plans = $functions->getAllEducationalPlansDefaultByNetwork($networks[$i]);

            EducationalPlan::create([
                'network' => strtolower($networks[$i]),
                'details' => $plans,
                'modify_prices' => 'no',
            ]);
        }
    }
}
