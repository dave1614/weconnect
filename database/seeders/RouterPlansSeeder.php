<?php

namespace Database\Seeders;

use App\Functions\UsefulFunctions;
use App\Models\RouterPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouterPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $functions = new UsefulFunctions();
        $networks = ['smile', 'spectranet'];

        for ($i = 0; $i < count($networks); $i++) {
            $plans = $functions->getAllRouterPlansDefaultByNetwork($networks[$i]);

            RouterPlan::create([
                'network' => strtolower($networks[$i]),
                'details' => $plans,
                'modify_prices' => 'no',
            ]);
        }
    }
}
