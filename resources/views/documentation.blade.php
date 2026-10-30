<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Newsapp API — Documentation</title>
    <style>
        :root { color-scheme: light dark; }
        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
            background: #f8fafc;
            color: #0f172a;
            line-height: 1.6;
        }
        main { max-width: 860px; margin: 0 auto; padding: 3rem 1.5rem 5rem; }
        h1 { font-size: 2rem; margin-bottom: .25rem; }
        h2 { margin-top: 2.5rem; font-size: 1.25rem; }
        p.sub { color: #64748b; margin-top: 0; }
        code {
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
            background: #e2e8f0;
            border-radius: .25rem;
            padding: .1rem .35rem;
            font-size: .9em;
        }
        pre {
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
            background: #0f172a;
            color: #e2e8f0;
            padding: 1rem 1.25rem;
            border-radius: .5rem;
            overflow-x: auto;
            font-size: .875rem;
        }
        table { width: 100%; border-collapse: collapse; font-size: .9rem; }
        th, td { text-align: left; padding: .6rem .5rem; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        th { font-size: .75rem; text-transform: uppercase; letter-spacing: .05em; color: #64748b; }
        .m { font-weight: 700; font-size: .75rem; }
        .get { color: #0369a1; }
        .post { color: #15803d; }
        .delete { color: #b91c1c; }
        .note { background: #fff; border-left: 4px solid #38bdf8; padding: .75rem 1rem; border-radius: .25rem; }
    </style>
</head>
<body>
    <main>
        <h1>Newsapp API</h1>
        <p class="sub">REST API reference · Laravel 12 · OpenAPI 3.0</p>

        <div class="note">
            The machine-readable contract lives in <code>doc/api-documentation.yml</code>.
            It can be imported into Postman, Insomnia, or published with Bump.sh.
        </div>

        <h2>Authentication</h2>
        <p>Exchange credentials for a token, then send it as a Bearer token:</p>
        <pre>POST /api/register
POST /api/token            { "email": "...", "password": "..." }

GET /api/posts
Authorization: Bearer &lt;your-api-token&gt;</pre>

        <h2>Endpoints</h2>
        <table>
            <thead>
                <tr><th>Method</th><th>Path</th><th>Auth</th><th>Description</th></tr>
            </thead>
            <tbody>
                <tr><td class="m get">GET</td><td><code>/api/posts</code></td><td>No</td><td>Paginated posts</td></tr>
                <tr><td class="m get">GET</td><td><code>/api/posts/{id}</code></td><td>No</td><td>Post with author and comments</td></tr>
                <tr><td class="m get">GET</td><td><code>/api/posts/categories/{id}</code></td><td>No</td><td>Posts in a category</td></tr>
                <tr><td class="m get">GET</td><td><code>/api/posts/author/{id}</code></td><td>No</td><td>Posts by an author</td></tr>
                <tr><td class="m get">GET</td><td><code>/api/posts/{id}/summary</code></td><td>No</td><td>Optional AI summary (cached)</td></tr>
                <tr><td class="m get">GET</td><td><code>/api/comments/posts/{id}</code></td><td>No</td><td>Comments on a post</td></tr>
                <tr><td class="m get">GET</td><td><code>/api/comments/author/{id}</code></td><td>No</td><td>Comments by an author</td></tr>
                <tr><td class="m get">GET</td><td><code>/api/authors</code></td><td>No</td><td>Paginated authors</td></tr>
                <tr><td class="m get">GET</td><td><code>/api/authors/{id}</code></td><td>No</td><td>Single author</td></tr>
                <tr><td class="m get">GET</td><td><code>/api/categories</code></td><td>No</td><td>Paginated categories</td></tr>
                <tr><td class="m post">POST</td><td><code>/api/register</code></td><td>No</td><td>Create an account</td></tr>
                <tr><td class="m post">POST</td><td><code>/api/token</code></td><td>No</td><td>Exchange credentials for a token</td></tr>
                <tr><td class="m post">POST</td><td><code>/api/posts</code></td><td>Yes</td><td>Create a post</td></tr>
                <tr><td class="m post">POST</td><td><code>/api/posts/{id}</code></td><td>Yes</td><td>Update own post</td></tr>
                <tr><td class="m delete">DELETE</td><td><code>/api/posts/{id}</code></td><td>Yes</td><td>Delete own post</td></tr>
                <tr><td class="m post">POST</td><td><code>/api/comments/posts/{id}</code></td><td>Yes</td><td>Comment on a post</td></tr>
                <tr><td class="m post">POST</td><td><code>/api/update-user/{id}</code></td><td>Yes</td><td>Update own profile</td></tr>
            </tbody>
        </table>

        <h2>Pagination</h2>
        <p>All lists accept <code>?page=N</code>. Page sizes come from the environment:</p>
        <pre>POSTS_PER_PAGE=15
AUTHORS_PER_PAGE=15
COMMENTS_PER_PAGE=15
CATEGORIES_PER_PAGE=15</pre>

        <h2>Errors</h2>
        <p>Validation errors return <code>422</code>, unauthenticated requests <code>401</code>,
            forbidden actions <code>403</code>, and missing resources <code>404</code> — always as JSON
            for <code>/api/*</code>.</p>

        <p><a href="{{ url('/') }}">← Back to home</a></p>
    </main>
</body>
</html>
