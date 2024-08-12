<?php

namespace Database\Seeders;

use App\Functions\UsefulFunctions;
use App\Models\CablePlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CablePlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $functions = new UsefulFunctions();
        $networks = ['DStv', 'GOtv', 'Startimes'];

        for ($i = 0; $i < count($networks); $i++) {
            $plans = $functions->getAllCablePlansDefaultByNetwork($networks[$i]);

            CablePlan::create([
                'network' => strtolower($networks[$i]),
                'details' => $plans,
                'modify_prices' => 'no',
            ]);
        }
    }
}
