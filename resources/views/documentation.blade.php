<?php
// resources/views/documentation.blade.php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>News API Documentation</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        .endpoint { background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .method { font-weight: bold; color: #0d6efd; }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">News API Documentation</h1>
        
        <div class="card mb-4">
            <div class="card-body">
                <h2>Authentication</h2>
                <p>API requests require a Bearer token in the Authorization header.</p>
                <pre>Authorization: Bearer your-token-here</pre>
            </div>
        </div>

        <h2 class="mb-3">Endpoints</h2>

        <div class="endpoint">
            <h3>News Articles</h3>
            
            <div class="mb-3">
                <span class="method">GET</span> /api/articles
                <p>Get all news articles</p>
                <strong>Query Parameters:</strong>
                <ul>
                    <li>page (optional) - Page number</li>
                    <li>per_page (optional) - Items per page</li>
                    <li>category (optional) - Filter by category</li>
                </ul>
            </div>

            <div class="mb-3">
                <span class="method">GET</span> /api/articles/{id}
                <p>Get a specific article</p>
            </div>

            <div class="mb-3">
                <span class="method">POST</span> /api/articles
                <p>Create a new article</p>
                <strong>Body Parameters:</strong>
                <ul>
                    <li>title (required) - Article title</li>
                    <li>content (required) - Article content</li>
                    <li>category_id (required) - Category ID</li>
                    <li>image (optional) - Article image</li>
                </ul>
            </div>
        </div>

        <div class="endpoint">
            <h3>Categories</h3>
            
            <div class="mb-3">
                <span class="method">GET</span> /api/categories
                <p>Get all categories</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h3>Response Format</h3>
                <pre>
{
    "status": "success",
    "data": [],
    "message": "",
    "meta": {
        "current_page": 1,
        "total": 0,
        "per_page": 10
    }
}
                </pre>
            </div>
        </div>
    </div>
</body>
</html>
