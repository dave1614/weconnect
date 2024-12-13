<?php

namespace Database\Seeders;

use App\Models\FollowDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FollowDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::inRandomOrder()->limit(50)->get('id');
        foreach ($users as $user) {
            $following = User::inRandomOrder()->limit(rand(1, 10))->get('id');
            foreach ($following as $follower) {

                FollowDetail::create([
                    'follower'=> $follower->id,
                    'followed'=> $user->id
                ]);
            }
        }
    }
}
