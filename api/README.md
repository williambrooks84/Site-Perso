# API Backend - Local setup

This backend is a Symfony + API Platform API used by the Nuxt frontend.

## Requirements

- Docker Desktop
- Docker Compose
- PHP 8.2+
- Composer
- MySQL client (optional)

## 1) Start the database and API

From the project root:

```bash
cd api
docker compose up -d --build
```

This starts:

- MySQL on `localhost:3307`
- Symfony API on `http://localhost:8000`

## 2) Run database migrations

```bash
cd api
docker compose exec api php bin/console doctrine:migrations:migrate --no-interaction
```

If you want to run the app directly without Docker for development:

```bash
cd api
composer install
php -S 127.0.0.1:8000 -t public
```

## 3) Check the API is reachable

```bash
curl http://localhost:8000/api/projects
```

Expected result: a JSON-LD response from API Platform.

## 4) Important environment notes

The project keeps local secrets in a local `.env` file, which is intentionally not committed.

Use the sample file as a template:

```bash
cp .env.example .env
```

Then adapt the values if needed for your local machine.

## 5) Default local URLs

- Frontend: `http://localhost:3000`
- API: `http://localhost:8000`
- MySQL: `127.0.0.1:3307`

## 6) Deployment safety for GitHub

To make sure the API still deploys correctly when you push to GitHub:

- keep `.env` untracked and local only
- commit `.env.example` instead
- never commit production secrets
- keep Docker configuration compatible with the target deployment environment

Typical Git-safe setup:

```bash
.gitignore includes:
  .env
  .env.*
  !.env.example
```

This ensures the repo remains safe while still giving deployment systems a working template.
