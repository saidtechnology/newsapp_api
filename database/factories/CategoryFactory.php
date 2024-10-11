<?php

namespace Database\Factories;

use App\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class CategoryFactory extends Factory
{

    
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

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
            'title' => $this->faker->word(),
        ];
    }
}