# routes/

HTTP and console entry points. Controller implementations live in `../app/Http/Controllers/`.

| File | Purpose |
|---|---|
| `api.php` | JSON API routes consumed by the Next.js frontend (mounted under `/api`) |
| `web.php` | Web routes — serves Laravel's `welcome` view at `/`. Filament mounts `/admin` via the panel provider. |
| `console.php` | Artisan closures (scheduled tasks, custom commands) |

## API routes

| Method | Path | Controller | Notes |
|---|---|---|---|
| GET | `/api/projects` | `ProjectController@index` | List published projects |
| GET | `/api/projects/{slug}` | `ProjectController@show` | Single project |
| GET | `/api/services` | `ServiceController@index` | List services |
| POST | `/api/contact` | `ContactController@store` | `throttle:5,1` — 5/min per IP |

Nginx adds a second rate-limit layer on `/api/contact` — see `../../ethostudio-infrastructure/nginx/default.conf`.
