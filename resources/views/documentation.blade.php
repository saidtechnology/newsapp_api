<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>News API Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .method { font-weight: bold; padding: 3px 8px; border-radius: 4px; }
        .get { background: #61affe; color: white; }
        .post { background: #49cc90; color: white; }
        .endpoint { border: 1px solid #ddd; padding: 20px; margin: 15px 0; border-radius: 8px; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">News API Documentation</h1>

        <!-- Getting Started -->
        <div class="card mb-4">
            <div class="card-body">
                <h2>Getting Started</h2>
                <ol>
                    <li>Register an account at <code>{{ config('app.url') }}/register</code></li>
                    <li>Login to get your API token</li>
                    <li>Include token in all API requests</li>
                </ol>
            </div>
        </div>

        <!-- Authentication -->
        <div class="card mb-4">
            <div class="card-body">
                <h2>Authentication</h2>
                <p>Add this header to all API requests:</p>
                <pre>Authorization: Bearer your-token-here</pre>
            </div>
        </div>

        <!-- API Endpoints -->
        <h2 class="mb-3">API Endpoints</h2>

        <!-- Articles -->
        <div class="endpoint">
            <h3>Articles</h3>
            
            <div class="mb-4">
                <span class="method get">GET</span>
                <code>/api/articles</code>
                <h4 class="mt-2">Get All Articles</h4>
                <p>Parameters:</p>
                <ul>
                    <li><code>page</code> - Page number (default: 1)</li>
                    <li><code>per_page</code> - Items per page (default: 10)</li>
                    <li><code>category</code> - Filter by category ID</li>
                </ul>
                <h5>Example Request:</h5>
                <pre>GET /api/articles?page=1&per_page=10&category=1</pre>
                <h5>Example Response:</h5>
                <pre>
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "title": "Example Article",
            "content": "Article content...",
            "category_id": 1,
            "created_at": "2024-03-13T00:00:00.000000Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "total": 50,
        "per_page": 10
    }
}</pre>
            </div>

            <div class="mb-4">
                <span class="method post">POST</span>
                <code>/api/articles</code>
                <h4 class="mt-2">Create Article</h4>
                <p>Required fields:</p>
                <ul>
                    <li><code>title</code> - Article title</li>
                    <li><code>content</code> - Article content</li>
                    <li><code>category_id</code> - Category ID</li>
                </ul>
                <h5>Example Request:</h5>
                <pre>
POST /api/articles
Content-Type: application/json

{
    "title": "New Article",
    "content": "Article content",
    "category_id": 1
}</pre>
            </div>
        </div>

        <!-- Error Handling -->
        <div class="card mt-4">
            <div class="card-body">
                <h3>Error Responses</h3>
                <p>When an error occurs, you'll receive:</p>
                <pre>
{
    "status": "error",
    "message": "Error description",
    "errors": {
        "field": ["Validation error message"]
    }
}</pre>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</body>
</html>
