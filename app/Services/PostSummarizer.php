<?php

namespace App\Services;

use App\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Generates short summaries for posts using any OpenAI-compatible endpoint
 * (Groq, Together, OpenRouter, llama.cpp, Ollama, ...).
 *
 * The provider is configured through environment variables so the project
 * never ships with a hard-coded key. Results are cached to keep free-tier
 * usage low.
 */
class PostSummarizer
{
    /**
     * @return array{summary: string, model: string}
     */
    public function summarize(Post $post): array
    {
        $config = config('newsapp.ai');

        if (! ($config['enabled'] ?? false) || empty($config['api_key'])) {
            throw new RuntimeException('AI summarization is not configured.');
        }

        $cacheKey = sprintf(
            'post-summary:%d:%s',
            $post->id,
            $post->updated_at?->getTimestamp() ?? 0
        );

        return Cache::remember($cacheKey, (int) $config['cache_ttl'], function () use ($post, $config) {
            return [
                'summary' => $this->requestSummary($post, $config),
                'model' => (string) $config['model'],
            ];
        });
    }

    /**
     * @param  array<string, mixed>  $config
     */
    private function requestSummary(Post $post, array $config): string
    {
        try {
            $response = Http::withToken((string) $config['api_key'])
                ->acceptJson()
                ->timeout((int) $config['timeout'])
                ->post(rtrim((string) $config['base_url'], '/').'/chat/completions', [
                    'model' => $config['model'],
                    'temperature' => 0.2,
                    'max_tokens' => 220,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a news editor. Summarise the article in three concise bullet points. Answer in the language of the article.',
                        ],
                        [
                            'role' => 'user',
                            'content' => trim("Title: {$post->title}\n\n".Str::limit((string) $post->content, (int) ($config['max_content_chars'] ?? 6000), '')),
                        ],
                    ],
                ]);

            $response->throw();
        } catch (\Throwable $exception) {
            throw new RuntimeException(
                'AI provider request failed: '.$exception->getMessage(),
                0,
                $exception
            );
        }

        $summary = trim((string) $response->json('choices.0.message.content', ''));

        if ($summary === '') {
            throw new RuntimeException('The AI provider returned an empty summary.');
        }

        return $summary;
    }
}
