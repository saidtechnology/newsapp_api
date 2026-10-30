<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pagination sizes
    |--------------------------------------------------------------------------
    |
    | Centralised pagination configuration. Controllers must use config()
    | instead of env() so that values survive `php artisan config:cache`.
    |
    */

    'posts_per_page' => (int) env('POSTS_PER_PAGE', 15),

    'authors_per_page' => (int) env('AUTHORS_PER_PAGE', 15),

    'comments_per_page' => (int) env('COMMENTS_PER_PAGE', 15),

    'categories_per_page' => (int) env('CATEGORIES_PER_PAGE', 15),

    /*
    |--------------------------------------------------------------------------
    | AI summarization (optional)
    |--------------------------------------------------------------------------
    |
    | Any OpenAI-compatible provider can be used (Groq, Together, OpenRouter,
    | Ollama, llama.cpp...). Summaries are only generated when AI is enabled
    | and an API key is present; otherwise the endpoint returns 503.
    |
    */

    'ai' => [
        'enabled' => (bool) env('NEWSAPP_AI_ENABLED', false),
        'base_url' => env('NEWSAPP_AI_BASE_URL', 'https://api.groq.com/openai/v1'),
        'api_key' => env('NEWSAPP_AI_API_KEY'),
        'model' => env('NEWSAPP_AI_MODEL', 'llama-3.1-8b-instant'),
        'timeout' => (int) env('NEWSAPP_AI_TIMEOUT', 20),
        'cache_ttl' => (int) env('NEWSAPP_AI_CACHE_TTL', 3600),
        'max_content_chars' => (int) env('NEWSAPP_AI_MAX_CONTENT_CHARS', 6000),
    ],

];
