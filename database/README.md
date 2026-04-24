# database/

Schema, seed data, and the local SQLite file.

```
migrations/   Schema definitions (run via `php artisan migrate`)
seeders/      Initial data (run via `php artisan db:seed`)
factories/    Model factories for tests
database.sqlite  Local SQLite database
```

## Tables

| Table | Source |
|---|---|
| `users` (+ `is_admin`) | Laravel default + Filament access flag |
| `cache`, `cache_locks` | Laravel default |
| `jobs`, `job_batches`, `failed_jobs` | Laravel default |
| `personal_access_tokens` | Laravel Sanctum |
| `categories` | Domain — project categorisation |
| `projects` | Domain — portfolio entries |
| `services` | Domain — services offered |
| `messages` | Domain — contact-form submissions |
| `media` | Spatie Media Library |

## Seeders

`DatabaseSeeder.php` creates:

1. An admin user. **Requires `ADMIN_PASSWORD` in `.env`** — seeding fails loudly if unset (deliberate, no default password).
2. Default categories: Poster, Banner, Flyer, Infographic, Product.
3. Example services.

Run it with `make seed` or `php artisan db:seed`.

## Factories

`UserFactory.php` is the only factory today.
