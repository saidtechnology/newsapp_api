<?php

namespace Database\Factories;

use App\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

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
            'title' => $this->faker->title(),
            'content' => $this->faker->text(400),
            'date_written' => now(),
            'featured_image' => $this->faker->imageUrl(),
            'votes_up' => $this->faker->numberBetween(1 , 100),
            'votes_down' => $this->faker->numberBetween(1 , 100),
            'user_id' => $this->faker->numberBetween(1 ,50),
            'category_id' => $this->faker->numberBetween(1 , 15),
        ];
    }
}