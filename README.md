# Ethostudio Backend

Laravel 11 API + Filament admin panel.

## Requirements
- Docker Desktop

## Setup

```bash
# 1. Install Laravel
composer create-project laravel/laravel .

# 2. Install packages
composer require filament/filament:"^3.2" spatie/laravel-medialibrary

# 3. Install Filament
php artisan filament:install --panels

# 4. Copy env
cp .env.example .env
php artisan key:generate

# 5. Run migrations and seed
php artisan migrate --seed

# 6. Create admin user (if not seeded)
php artisan make:filament-user
```

## Running locally (via Docker)

Start from the infrastructure project:

```bash
cd ../ethostudio-infrastructure
docker compose up
```

Then visit:
- API: http://localhost:8000/api
- Admin: http://localhost:8000/admin

## API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| GET | /api/projects | List published projects |
| GET | /api/projects/{slug} | Single project |
| GET | /api/services | List services |
| POST | /api/contact | Send contact message |
