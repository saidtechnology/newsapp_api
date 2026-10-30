<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_posts(): void
    {
        $this->getJson('/api/posts')->assertOk();
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
    }

    public function test_can_get_token_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/token', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertOk();
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

    public function test_user_cannot_update_another_users_post(): void
    {
        $owner = User::factory()->create();
        $attacker = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        $this->withHeader('Authorization', 'Bearer '.$attacker->api_token)
            ->postJson("/api/posts/{$post->id}", ['title' => 'Hacked'])
            ->assertForbidden();
    }

    public function test_showing_missing_post_returns_404(): void
    {
        $this->getJson('/api/posts/999999')->assertNotFound();
    }
}
