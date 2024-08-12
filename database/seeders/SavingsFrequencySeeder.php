<?php

namespace Database\Seeders;

use App\Models\SavingsFrequency;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SavingsFrequencySeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
        SavingsFrequency::create([
            'label' => 'daily',
        ]);
        SavingsFrequency::create([
            'label' => 'weekly',
        ]);    

        SavingsFrequency::create([
            'label' => 'monthly',
        ]);
           
    }
}
