<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class SummaryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    private function enableAi(): void
    {
        config([
            'newsapp.ai.enabled' => true,
            'newsapp.ai.api_key' => 'test-key',
            'newsapp.ai.base_url' => 'https://ai.test/v1',
            'newsapp.ai.model' => 'test-model',
            'newsapp.ai.cache_ttl' => 60,
        ]);
    }

    public function test_summary_returns_503_when_ai_is_disabled(): void
    {
        config(['newsapp.ai.enabled' => false]);

        $post = Post::factory()->create();

        $this->getJson("/api/posts/{$post->id}/summary")
            ->assertStatus(503)
            ->assertJsonPath('message', 'AI summarization is currently unavailable.');
    }

    public function test_summary_is_generated_through_openai_compatible_provider(): void
    {
        $this->enableAi();

        Http::fake([
            'ai.test/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => "- Point one\n- Point two"]],
                ],
            ]),
        ]);

        $post = Post::factory()->create(['title' => 'Breaking news']);

        $this->getJson("/api/posts/{$post->id}/summary")
            ->assertOk()
            ->assertJsonPath('data.post_id', $post->id)
            ->assertJsonPath('data.model', 'test-model')
            ->assertJsonPath('data.summary', "- Point one\n- Point two");

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://ai.test/v1/chat/completions'
                && $request->hasHeader('Authorization', 'Bearer test-key')
                && $request['model'] === 'test-model';
        });
    }

    public function test_summary_is_cached_between_requests(): void
    {
        $this->enableAi();

        Http::fake([
            'ai.test/*' => Http::response([
                'choices' => [['message' => ['content' => 'Cached summary']]],
            ]),
        ]);

        $post = Post::factory()->create();

        $this->getJson("/api/posts/{$post->id}/summary")->assertOk();
        $this->getJson("/api/posts/{$post->id}/summary")->assertOk();

        Http::assertSentCount(1);
    }

    public function test_summary_returns_503_when_provider_fails(): void
    {
        $this->enableAi();

        Http::fake([
            'ai.test/*' => Http::response(['error' => 'rate limited'], 429),
        ]);

        $post = Post::factory()->create();

        $this->getJson("/api/posts/{$post->id}/summary")->assertStatus(503);
    }

    public function test_summary_endpoint_is_rate_limited(): void
    {
        config(['newsapp.ai.enabled' => false]);

        $post = Post::factory()->create();

        for ($i = 0; $i < 10; $i++) {
            $this->getJson("/api/posts/{$post->id}/summary")->assertStatus(503);
        }

        $this->getJson("/api/posts/{$post->id}/summary")->assertStatus(429);
    }

    public function test_content_sent_to_provider_is_truncated(): void
    {
        $this->enableAi();

        Http::fake([
            'ai.test/*' => Http::response([
                'choices' => [['message' => ['content' => 'Short summary']]],
            ]),
        ]);

        $post = Post::factory()->create([
            'title' => 'Long article',
            'content' => str_repeat('A', 12000),
        ]);

        $this->getJson("/api/posts/{$post->id}/summary")->assertOk();

        Http::assertSent(function (Request $request) {
            return Str::length($request['messages'][1]['content']) <= 6100;
        });
    }
}
