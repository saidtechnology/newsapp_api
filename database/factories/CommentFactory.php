<?php

namespace Database\Factories;

use App\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // use the factory to create a Faker\Generator instance
        //$faker = Faker\Factory::create();

        return [
            'content' => $this->faker->text(),
            'date_written' => now(),
            'user_id' => $this->faker->numberBetween(1 , 50),
            'post_id' => $this->faker->numberBetween(1 , 500),
        ];
    }
}
