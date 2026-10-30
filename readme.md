# Newsapp API

[![Laravel](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

A clean, RESTful news API built with Laravel. It exposes authors, categories, posts and comments with token-based authentication for creating and managing content.

## Features

- **REST API** — Resource-based JSON API under `/api/*`
- **Token authentication** — Simple `api_token` flow (register → login → use `Authorization: Bearer <token>`)
- **Ownership checks** — Users can only update/delete their own posts and profiles
- **Pagination** — All lists are paginated via configurable per-page values
- **Image uploads** — Attach a `featured_image` to posts or an `avatar` to a profile
- **Optional AI summaries** — Any OpenAI-compatible provider (Groq, Together, OpenRouter, Ollama) via `GET /api/posts/{id}/summary`, cached to respect free tiers
- **OpenAPI spec** — Machine-readable documentation in [`doc/api-documentation.yml`](doc/api-documentation.yml)
- **Tested** — PHPUnit feature/unit tests and a GitHub Actions matrix (PHP 8.2–8.4)

## Requirements

- PHP >= 8.2 with `mbstring`, `xml`, `curl`, `openssl` and `pdo_sqlite` (or `pdo_mysql`)
- Composer
- SQLite / MySQL / PostgreSQL

## Installation

```bash
# Clone the repository
git clone https://github.com/saidtechnology/newsapp_api.git
cd newsapp_api

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in .env (SQLite works out of the box)
touch database/database.sqlite

# Run migrations and seed sample data
php artisan migrate --seed

# (Optional) Link storage for uploaded images
php artisan storage:link

# Serve the application
php artisan serve
```
## API Reference

Full interactive documentation is available via [Bump.sh](https://bump.sh/) using [`doc/api-documentation.yml`](doc/api-documentation.yml).

### Quick overview

| Method | Endpoint | Auth | Description |
| --- | --- | --- | --- |
| `POST` | `/api/register` | No | Register a new user |
| `POST` | `/api/token` | No | Get API token for credentials |
| `GET` | `/api/authors` | No | List authors |
| `GET` | `/api/authors/{id}` | No | Show author |
| `GET` | `/api/posts/author/{id}` | No | Posts by author |
| `GET` | `/api/comments/author/{id}` | No | Comments by author |
| `GET` | `/api/categories` | No | List categories |
| `GET` | `/api/posts/categories/{id}` | No | Posts by category |
| `GET` | `/api/posts` | No | List posts (includes author/comments on `show`) |
| `GET` | `/api/posts/{id}` | No | Show post |
| `GET` | `/api/comments/posts/{id}` | No | Comments on post |
| `GET` | `/api/posts/{id}/summary` | No | AI summary (optional, cached) |
| `POST` | `/api/posts` | **Yes** | Create post |
| `POST` | `/api/posts/{id}` | **Yes** | Update post (owner) |
| `DELETE` | `/api/posts/{id}` | **Yes** | Delete post (owner) |
| `POST` | `/api/comments/posts/{id}` | **Yes** | Add comment |
| `POST` | `/api/update-user/{id}` | **Yes** | Update own profile |

> Pagination uses `?page=`. Page sizes are controlled by `POSTS_PER_PAGE`, `AUTHORS_PER_PAGE`, `COMMENTS_PER_PAGE`, `CATEGORIES_PER_PAGE`.

## Optional AI summaries

The summary endpoint is provider-agnostic and disabled by default. Point it at any
OpenAI-compatible API (the examples use Groq's free tier) and set a key:

```dotenv
NEWSAPP_AI_ENABLED=true
NEWSAPP_AI_BASE_URL=https://api.groq.com/openai/v1
NEWSAPP_AI_API_KEY=gsk_...
NEWSAPP_AI_MODEL=llama-3.1-8b-instant
```

```bash
curl http://localhost:8000/api/posts/1/summary
```

Summaries are cached for `NEWSAPP_AI_CACHE_TTL` seconds (default 1 hour).
Content is truncated to `NEWSAPP_AI_MAX_CONTENT_CHARS` (default 6000) and the
endpoint allows 10 requests per minute per client. When AI is disabled or the
provider errors, the endpoint returns `503` — it never breaks the rest of the API.
No key is committed to the repository.

## Testing

```bash
cp .env.example .env
php artisan key:generate
php artisan test
```

The suite uses SQLite in-memory by default (`phpunit.xml`) and covers public
endpoints, registration/token auth, ownership rules, validation, relations and
the AI summarizer (with a faked HTTP client).

Code style is enforced with [Laravel Pint](https://laravel.com/docs/pint):

```bash
vendor/bin/pint --test
```

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## Security

If you discover a security vulnerability, please review [SECURITY.md](SECURITY.md).

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<!-- Automated reviews -->
This repository uses [CodeRabbit](https://www.coderabbit.ai/) for automated open-source pull-request reviews.
