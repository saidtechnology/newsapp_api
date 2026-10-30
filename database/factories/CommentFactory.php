<?php

namespace Database\Factories;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Comment>
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph(),
            'date_written' => now(),
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
        ];
    }
}
