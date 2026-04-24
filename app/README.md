# app/

Laravel application code. Domain models, HTTP controllers, Filament admin resources, and service providers.

## Layout

```
Filament/    Admin-panel resources (forms, tables, pages)
Http/        API controllers and HTTP plumbing
Models/      Eloquent models
Providers/   Service providers (including Filament panel)
```

## Filament/

Admin resources shown in the `/admin` panel.

| File | Manages |
|---|---|
| `Resources/ProjectResource.php` | Portfolio projects (CRUD + media uploads) |
| `Resources/ServiceResource.php` | Services offered |
| `Resources/MessageResource.php` | Incoming contact-form messages |

Panel registration lives in `../Providers/Filament/AdminPanelProvider.php`.

## Http/

API surface consumed by the Next.js frontend. All routes are wired in `../../routes/api.php`.

| Controller | Endpoint(s) |
|---|---|
| `Controllers/Api/ProjectController.php` | `GET /api/projects`, `GET /api/projects/{slug}` |
| `Controllers/Api/ServiceController.php` | `GET /api/services` |
| `Controllers/Api/ContactController.php` | `POST /api/contact` (rate-limited) |

`Controllers/Controller.php` is the base controller.

## Models/

Eloquent models, each mapped to a migration in `../../database/migrations/`.

| Model | Notes |
|---|---|
| `User.php` | Auth + `is_admin` flag gates Filament access |
| `Project.php` | Uses Spatie Media Library for image uploads |
| `Service.php` | Simple title/description/icon records |
| `Category.php` | Categorises projects (Poster, Banner, Flyer, …) |
| `Message.php` | Contact-form submissions persisted for admin review |

## Providers/

| File | Purpose |
|---|---|
| `AppServiceProvider.php` | Framework bootstrap hooks |
| `Filament/AdminPanelProvider.php` | Registers the `/admin` Filament panel, brand, resources, middleware |
