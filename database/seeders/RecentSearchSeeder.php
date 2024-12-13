<?php

namespace Database\Seeders;

use App\Functions\UsefulFunctions;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RecentSearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $functions = new UsefulFunctions();
        $faker = Faker::create();

        $user_id = 11;
        $types = ['tag', 'search', 'user'];

        for($i = 0; $i < 50; $i++) {
            $type = $types[rand(0, 2)];
            $search = null;
            $searched_user_id = null;
            $word = $faker->word();

            if($type == 'tag'){
                $search = '#'.$word;
            }else if($type == 'search'){
                $search = $word;
            }

            $searched_user_id = $type == "user" ? User::where('id', '!=', 0)->inRandomOrder()->first()->id : null;

            $arr = [
                'user_id' => $user_id,
                'type' => $type,
                'search' => $search,
                'searched_user_id' => $searched_user_id
            ];

            $functions->createRecentSearch($arr);
        }

        // \App\Models\RecentSearch::factory(10)->create();
    }
}
