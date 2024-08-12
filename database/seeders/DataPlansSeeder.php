<?php

namespace Database\Seeders;

use App\Functions\UsefulFunctions;
use App\Models\DataPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $functions = new UsefulFunctions();
        $networks = ['MTN', 'Glo', 'Airtel', '9mobile'];

        for($i = 0; $i < count($networks); $i++){
            $plans = $functions->getAllDataPlansDefaultByNetwork($networks[$i]);

            DataPlan::create([
                'network' => strtolower($networks[$i]),
                'details' => $plans,
                'modify_prices' => 'no',
            ]);
        }
    }
}
