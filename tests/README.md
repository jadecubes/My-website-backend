# tests/

PHPUnit test suite. Run with `php artisan test` or `./vendor/bin/phpunit`.

```
TestCase.php   Base test case (bootstraps the Laravel app)
Feature/       HTTP-level tests (requests, responses, DB state)
Unit/          Pure unit tests with no framework boot required
```

## Feature tests

| Test | Covers |
|---|---|
| `Feature/Api/ProjectApiTest.php` | `GET /api/projects`, `GET /api/projects/{slug}` |
| `Feature/Api/ServiceApiTest.php` | `GET /api/services` |
| `Feature/Api/ContactApiTest.php` | `POST /api/contact` validation + throttling |
| `Feature/Admin/PanelAccessTest.php` | Filament `/admin` access gated by `users.is_admin` |
| `Feature/ExampleTest.php` | Laravel scaffold |

## Unit tests

`Unit/ExampleTest.php` — Laravel scaffold.

## Running a subset

```bash
php artisan test --filter=ProjectApiTest
php artisan test tests/Feature/Api
```

Configuration (including the sqlite-in-memory test DB) is in `../phpunit.xml`.
