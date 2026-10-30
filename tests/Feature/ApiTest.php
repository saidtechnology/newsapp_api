<?php

namespace Tests\Feature;

use App\Category;
use App\Comment;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_posts(): void
    {
        Post::factory()->count(3)->create();

        $this->getJson('/api/posts')
            ->assertOk()
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_can_list_authors(): void
    {
        $this->getJson('/api/authors')->assertOk();
    }

    public function test_can_list_categories(): void
    {
        $this->getJson('/api/categories')->assertOk();
    }

    public function test_can_register_user(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $this->assertNotEmpty(User::where('email', 'test@example.com')->first()->api_token);
    }

    public function test_registration_rejects_duplicate_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->postJson('/api/register', [
            'name' => 'Someone',
            'email' => 'taken@example.com',
            'password' => 'password123',
        ])->assertUnprocessable()->assertJsonValidationErrors('email');
    }

    public function test_can_get_token_with_valid_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/token', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk()->assertJsonPath('data.token', $user->api_token);
    }

    public function test_token_rejects_invalid_credentials(): void
    {
        $this->postJson('/api/token', [
            'email' => 'missing@example.com',
            'password' => 'wrong',
        ])->assertUnauthorized();
    }

    public function test_creating_post_requires_auth(): void
    {
        $category = Category::factory()->create();

        $this->postJson('/api/posts', [
            'title' => 'Test',
            'content' => 'Body',
            'category_id' => $category->id,
        ])->assertUnauthorized();
    }

    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer '.$user->api_token)
            ->postJson('/api/posts', [
                'title' => 'My Post',
                'content' => 'Hello world',
                'category_id' => $category->id,
            ]);

        $response->assertCreated();
        $this->assertDatabaseHas('posts', ['title' => 'My Post', 'user_id' => $user->id]);
    }

    public function test_creating_post_validates_category(): void
    {
        $user = User::factory()->create();

        $this->withHeader('Authorization', 'Bearer '.$user->api_token)
            ->postJson('/api/posts', [
                'title' => 'No category',
                'content' => 'Body',
                'category_id' => 999999,
            ])->assertUnprocessable()->assertJsonValidationErrors('category_id');
    }

    public function test_user_cannot_update_another_users_post(): void
    {
        $owner = User::factory()->create();
        $attacker = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $owner->id]);

        $this->withHeader('Authorization', 'Bearer '.$attacker->api_token)
            ->postJson("/api/posts/{$post->id}", ['title' => 'Hacked'])
            ->assertForbidden();
    }

    public function test_owner_can_update_and_delete_post(): void
    {
        $owner = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $owner->id]);

        $this->withHeader('Authorization', 'Bearer '.$owner->api_token)
            ->postJson("/api/posts/{$post->id}", ['title' => 'Updated title'])
            ->assertOk()
            ->assertJsonPath('data.title', 'Updated title');

        $this->withHeader('Authorization', 'Bearer '.$owner->api_token)
            ->deleteJson("/api/posts/{$post->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_authenticated_user_can_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->withHeader('Authorization', 'Bearer '.$user->api_token)
            ->postJson("/api/comments/posts/{$post->id}", ['content' => 'Nice article'])
            ->assertCreated();

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'content' => 'Nice article',
        ]);
    }

    public function test_comment_requires_content(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->withHeader('Authorization', 'Bearer '.$user->api_token)
            ->postJson("/api/comments/posts/{$post->id}", [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('content');
    }

    public function test_showing_post_includes_author_and_comments(): void
    {
        $post = Post::factory()->create();
        Comment::factory()->count(2)->create(['post_id' => $post->id]);

        $this->getJson("/api/posts/{$post->id}")
            ->assertOk()
            ->assertJsonCount(2, 'data.comments');
    }

    public function test_showing_missing_post_returns_404(): void
    {
        $this->getJson('/api/posts/999999')->assertNotFound();
    }

    public function test_showing_missing_author_returns_404(): void
    {
        $this->getJson('/api/authors/999999')->assertNotFound();
    }
}
