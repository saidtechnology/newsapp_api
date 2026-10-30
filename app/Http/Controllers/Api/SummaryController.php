<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use App\Services\PostSummarizer;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class SummaryController extends Controller
{
    /**
     * Return a cached AI summary for a post.
     */
    public function show(PostSummarizer $summarizer, int $id)
    {
        $post = Post::findOrFail($id);

        try {
            $result = $summarizer->summarize($post);
        } catch (RuntimeException $exception) {
            Log::warning('AI summarization failed', [
                'post_id' => $post->id,
                'reason' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' => 'AI summarization is currently unavailable.',
            ], 503);
        }

        return response()->json([
            'data' => [
                'post_id' => $post->id,
                'summary' => $result['summary'],
                'model' => $result['model'],
            ],
        ]);
    }
}
