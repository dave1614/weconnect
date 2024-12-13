<?php

namespace Database\Seeders;

use App\Models\CommunityLeaderRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunityLeaderRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        CommunityLeaderRole::create([
            'name' => 'King',

        ]);

        CommunityLeaderRole::create([
            'name' => 'Chief',

        ]);

        CommunityLeaderRole::create([
            'name' => 'Cabinet Member',

        ]);
    }
}
