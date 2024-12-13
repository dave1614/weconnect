<?php

namespace Database\Seeders;

use App\Functions\UsefulFunctions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $functions = new UsefulFunctions();

        $functions->createDummyPostsForAllUsers();
    }
}