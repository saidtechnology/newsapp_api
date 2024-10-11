<?php

use App\Category;
use App\Comment;
use App\Post;
use App\User;
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
        User::factory()->count(30)->create(); 
        Category::factory()->count(15)->create(); 
        Post::factory()->count(500)->create(); 
        Comment::factory()->count(1500)->create();
    }
}
