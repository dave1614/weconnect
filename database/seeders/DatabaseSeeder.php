<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            CountrySeeder::class,
            InecStateSeeder::class,
            InecLgaSeeder::class,
            InecWardSeeder::class,
            RegionSeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            UserSeeder::class,
            MlmDbSeeder::class,
            MlmChargesTableSeeder::class,
            CommunityLeaderRoleSeeder::class,
            VtuPlatformTableSeeder::class,
            EtisalatComboDataPlansTableSeeder::class,
            // SavingsFrequencySeeder::class,
            // SavingsDurationSeeder::class,
            AirtimeTopupSeeder::class,
            DataPlansSeeder::class,
            CablePlansSeeder::class,
            RouterPlansSeeder::class,
            EducationalPlanSeeder::class,

            FollowDetailSeeder::class,
            PostSeeder::class,
        ]);

    }
}
