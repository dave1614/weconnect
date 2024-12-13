<?php

namespace Database\Factories;

use App\Functions\UsefulFunctions;
use App\Models\InecWard;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_name = fake()->userName();
        $functions = new UsefulFunctions();
        $ward = InecWard::inRandomOrder()->first();
        return [
            // 'name' => fake()->name(),
            // 'email' => fake()->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            // 'password' => static::$password ??= Hash::make('password'),
            // 'remember_token' => Str::random(10),



            'sponsor_user_id' => User::inRandomOrder()->first()->id,
            'name' => fake()->name(),
            'user_name' => $user_name,
            'slug' => $functions->generateUniqueSlugForUser($user_name),
            'email' => fake()->unique()->safeEmail(),
            'country_id' => 151,
            'state_id' => $ward->inec_state_id,
            'lga_id' =>  $ward->inec_lga_id,
            'ward_id' =>  $ward->id,
            'phone' => fake()->numerify('08#########'),
            'password' => Hash::make("Dave1614.."),
            'remember_token' => Str::random(10),
        ];


    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
