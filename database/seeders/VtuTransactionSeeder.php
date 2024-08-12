<?php

namespace Database\Seeders;

use App\Models\VtuTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VtuTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        VtuTransaction::factory(5000)->create();
    }
}
