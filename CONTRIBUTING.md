# Contributing to Newsapp API

Thanks for your interest in improving this project! All contributions are welcome.

## Getting started

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-improvement`
3. Install dependencies: `composer install`
4. Copy `.env.example` to `.env` and generate `APP_KEY`
5. Run migrations: `php artisan migrate`
6. Make your changes and run tests

## Guidelines

- **Follow PSR-12**. Run `vendor/bin/pint` before committing.
- **Write tests** for new features or bug fixes.
- **Keep it simple** — this is an API-first project; avoid leaking data through web routes.
- **Validate everything** — use Laravel validation and authorization checks.
- **Update docs** — if you change an endpoint, update `doc/api-documentation.yml` and `readme.md`.

## Pull requests

- Keep PRs focused and small where possible
- Describe the problem, solution and testing performed
- Ensure CI passes (tests + lint)

## Reporting bugs

Open a [GitHub issue](../../issues/new/choose) with reproduction steps, expected vs actual behaviour and environment details.

## Code of Conduct

By participating in this project you agree to uphold our [Code of Conduct](CODE_OF_CONDUCT.md).
