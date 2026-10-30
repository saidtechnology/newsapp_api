<?php

namespace Tests\Unit;

use App\Category;
use App\Comment;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_belongs_to_author_and_category(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $this->assertTrue($post->author->is($user));
        $this->assertTrue($post->category->is($category));
    }

    public function test_user_has_many_posts_and_comments(): void
    {
        $user = User::factory()->create();
        Post::factory()->count(2)->create(['user_id' => $user->id]);
        Comment::factory()->count(3)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->posts);
        $this->assertCount(3, $user->comments);
    }

    public function test_comment_belongs_to_post_and_author(): void
    {
        $post = Post::factory()->create();
        $author = User::factory()->create();
        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $author->id,
        ]);

        $this->assertTrue($comment->post->is($post));
        $this->assertTrue($comment->author->is($author));
    }

    public function test_api_token_is_hidden_from_serialization(): void
    {
        $user = User::factory()->create();

        $this->assertArrayNotHasKey('api_token', $user->toArray());
        $this->assertArrayNotHasKey('password', $user->toArray());
    }
}
