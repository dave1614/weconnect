<?php

namespace Database\Seeders;

use App\Functions\UsefulFunctions;
use App\Models\AirtimeTopup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirtimeTopupSeeder extends Seeder
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

        for ($i = 0; $i < count($networks); $i++) {
            $network = strtolower($networks[$i]);
            AirtimeTopup::create([
                'network' => $network,
                'discount' => 0.00
            ]);
        }
    }
}
