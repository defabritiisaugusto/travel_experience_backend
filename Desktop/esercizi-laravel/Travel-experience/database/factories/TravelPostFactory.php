<?php

namespace Database\Factories;

use App\Models\TravelPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TravelPost>
 */
class TravelPostFactory extends Factory
{
    protected $model = TravelPost::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'location' => fake()->city(),
            'country' => fake()->country(),
            'description' => fake()->paragraphs(3, true),
            'user_id' => User::factory(),
        ];
    }
}
