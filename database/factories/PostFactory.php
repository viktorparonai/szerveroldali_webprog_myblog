<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake() -> words(3, true),
            'content' => fake() -> paragraph(),
            'is_public' => fake() -> boolean(),
            'author_id' => User::inRandomOrder() -> first() -> id

        ];

    }
}
