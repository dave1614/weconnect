<?php

namespace Database\Seeders;

use App\Models\SavingsDuration;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SavingsDurationSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        SavingsDuration::create([
            'num' => 1,
            'type' => 'month',
            'label' => '1 month',
        ]);

        SavingsDuration::create([
            'num' => 3,
            'type' => 'month',
            'label' => '3 months',
        ]);

        SavingsDuration::create([
            'num' => 6,
            'type' => 'month',
            'label' => '6 months',
        ]);

        SavingsDuration::create([
            'num' => 1,
            'type' => 'year',
            'label' => '1 year',
        ]);

        SavingsDuration::create([
            'num' => 2,
            'type' => 'year',
            'label' => '2 years',
        ]);

        SavingsDuration::create([
            'num' => 3,
            'type' => 'year',
            'label' => '3 years',
        ]);


        
    }
}

