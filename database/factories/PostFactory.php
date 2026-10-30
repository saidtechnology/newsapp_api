<?php

namespace Database\Factories;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Post>
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraphs(3, true),
            'date_written' => now(),
            'featured_image' => $this->faker->imageUrl(),
            'votes_up' => $this->faker->numberBetween(0, 100),
            'votes_down' => $this->faker->numberBetween(0, 100),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
