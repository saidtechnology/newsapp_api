<?php

namespace Database\Seeders;

use App\Category;
use App\Comment;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed a small but consistent dataset for local development.
     */
    public function run(): void
    {
        $users = User::factory()->count(30)->create();
        $categories = Category::factory()->count(15)->create();

        $posts = Post::factory()
            ->count(500)
            ->recycle($users)
            ->recycle($categories)
            ->create();

        Comment::factory()
            ->count(1500)
            ->recycle($users)
            ->recycle($posts)
            ->create();
    }
}
