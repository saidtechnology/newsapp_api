<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Newsapp API') }}</title>
    <style>
        :root { color-scheme: light dark; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            padding: 2rem;
        }
        main { width: min(680px, 100%); }
        .badge {
            display: inline-block;
            font-size: .75rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #38bdf8;
            border: 1px solid #1e3a5f;
            border-radius: 999px;
            padding: .25rem .75rem;
            margin-bottom: 1.25rem;
        }
        h1 { font-size: clamp(2rem, 6vw, 3rem); margin: 0 0 1rem; line-height: 1.1; }
        p.lead { color: #94a3b8; font-size: 1.05rem; line-height: 1.7; margin: 0 0 2rem; }
        code {
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: .375rem;
            padding: .1rem .35rem;
            font-size: .9em;
        }
        .actions { display: flex; flex-wrap: wrap; gap: .75rem; margin-bottom: 2.5rem; }
        .btn {
            display: inline-block;
            text-decoration: none;
            padding: .7rem 1.2rem;
            border-radius: .5rem;
            font-weight: 600;
            font-size: .95rem;
        }
        .btn-primary { background: #38bdf8; color: #0f172a; }
        .btn-ghost { border: 1px solid #334155; color: #e2e8f0; }
        .grid { display: grid; gap: .75rem; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }
        .card { background: #111c33; border: 1px solid #1e293b; border-radius: .75rem; padding: 1rem; }
        .card strong { display: block; margin-bottom: .35rem; }
        .card span { color: #94a3b8; font-size: .875rem; }
        footer { margin-top: 2.5rem; color: #64748b; font-size: .8rem; }
    </style>
</head>
<body>
    <main>
        <span class="badge">Laravel 12 · REST API</span>
        <h1>Newsapp API</h1>
        <p class="lead">
            A clean JSON API for a news platform: authors, categories, posts and comments,
            with token authentication, ownership checks and optional AI summaries.
        </p>

        <div class="actions">
            <a class="btn btn-primary" href="{{ route('documentation') }}">API documentation</a>
            <a class="btn btn-ghost" href="https://github.com/saidtechnology/newsapp_api">GitHub</a>
        </div>

        <div class="grid">
            <div class="card"><strong>REST</strong><span>All resources under <code>/api</code></span></div>
            <div class="card"><strong>Token auth</strong><span><code>Authorization: Bearer &lt;token&gt;</code></span></div>
            <div class="card"><strong>OpenAPI 3</strong><span><code>doc/api-documentation.yml</code></span></div>
            <div class="card"><strong>Tests + CI</strong><span>PHPUnit &amp; GitHub Actions</span></div>
        </div>

        <footer>MIT licensed · built with Laravel</footer>
    </main>
</body>
</html>
