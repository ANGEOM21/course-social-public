<!--
This file guides AI coding agents (Copilot-style) to be immediately productive in this repository.
Keep it concise and codebase-specific. Update when project structure or workflows change.
-->

# Copilot instructions for course-social-public

Core intent: help an AI coding agent make safe, useful edits in this Laravel 10 app with Livewire/Volt views.

- Project root: Laravel app (PHP 8.1+, Laravel 10). Primary entry points: `public/index.php`, `routes/*.php`, `app/Http/Controllers`, `resources/views`.
- Frontend: Vite + Tailwind related packages in `package.json`. Livewire + Volt for component routing (see `routes/web.php`).

Key knowledge (quick):

- Routing: `app/Providers/RouteServiceProvider.php` auto-loads all `routes/*.php` except `api.php` and `console.php`. When adding routes, put them in `routes/*.php` and they will be grouped with `web` middleware (example: `routes/web.php`, `routes/students.php`, `routes/admin.php`). `routes/api.php` is registered under `/api` with `api` middleware.

- Volt + Livewire: This project uses `Livewire\Volt\Volt` for page components. Example: `Volt::route('/', 'pages.landing.index')->name('landing.index');` in `routes/web.php`. Look for Livewire components under `resources/views/pages` and `app/Http/Livewire` (if present).

- Model conventions: database models use `Tbl` prefix and explicit primary keys (example: `app/Models/TblCourse.php` defines `protected $primaryKey = 'id_course'` and `$table = 'tbl_courses'`). When referencing relations, follow existing naming (e.g., `tbl_modules(), tbl_enrollments()`). Prefer using existing model method names when adding queries.

- Controllers: Controllers live under `app/Http/Controllers`. Admin and student areas may be separated by route files like `admin.php` and `students.php`. Use existing controller patterns: controllers often extend `App\Http\Controllers\Controller` and use Eloquent models directly.

- Migrations & Factories: Standard Laravel locations (`database/migrations`, `database/factories`). Some older backup models persist in `BCKP/` — do not assume they are in use.

Developer workflows (commands you can run / suggest):

- Install PHP deps (Composer):

```pwsh
composer install
```

- Dev server (using built-in PHP server / Laragon):

```pwsh
php artisan serve
```

- Frontend assets (Vite):

```pwsh
npm install
npm run dev    # runs vite
npm run build  # build assets for production
```

- Common artisan tasks:

```pwsh
php artisan migrate        # run migrations
php artisan db:seed        # seed database
php artisan key:generate   # create .env APP_KEY (post-create script runs this)
```

- Tests (PHPUnit):

```pwsh
./vendor/bin/phpunit
```

Project-specific patterns & tips for code edits:

- When adding routes, prefer editing/adding files in `routes/` rather than registering routes in service providers — `RouteServiceProvider` intentionally picks up files there.
- Preserve model naming and primary key conventions (`Tbl*`, `id_*`) when creating new models or queries.
- Volt route targets use dot syntax mapping to `resources/views` Volt components (example above). Match the existing naming (`pages.landing.index` -> `resources/views/pages/landing.blade.php` or Volt component).
- Database queries normally use Eloquent models directly (see `app/Http/Controllers/CourseController.php`). Follow existing pagination and eager-loading patterns used in controllers (look for `with()` and `paginate()` usages).

Integration points & external deps to be aware of:

- Social login: `laravel/socialite` and `websitinu/laravel-socialite-google-one-tap` (check auth flows in `routes/auth.php` and `app/Http/Controllers/Auth/*`).
- Livewire and Volt: live server updates use Vite and Livewire; be careful when editing components that are referenced by Volt routes.
- Excel / Word / PDF exports: `maatwebsite/excel`, `phpoffice/phpword`, and `mpdf/mpdf` are used for export features (see `app/Http/Controllers/CertificateController.php` and `resources/views/export`).

Testing & CI notes (discoverable):

- `phpunit.xml` sets testing env values; tests run via `vendor/bin/phpunit`. The file currently comments out sqlite in-memory DB; CI may configure database separately.

Conventions to follow when editing:

- Keep PSR-4 autoloading (`App\` => `app/`). New classes should follow folder namespaces.
- Use existing `Tbl*` models for DB interaction; add methods to those models when behaviour is shared across controllers.
- Keep view filenames and Volt route targets consistent. Example mapping: `pages.landing.index` -> `resources/views/pages/landing.blade.php`.

Files & locations worth checking first (examples):

- `app/Providers/RouteServiceProvider.php` — route file auto-load behavior (important for where to add routes).
- `routes/*.php` — all route declarations. Add routes here.
- `app/Models/TblCourse.php`, `TblModule.php`, `TblStudent.php` — model conventions and relations.
- `app/Http/Controllers/*Controller.php` — controller patterns and common Eloquent usage.
- `resources/views/pages` and `resources/views/layouts` — Volt/Blade view patterns.
- `package.json` and `vite.config.js` — frontend dev/build commands.

When making PRs / edits:

- Run lint/test/build locally: `composer install`, `npm install`, `npm run dev` (or `npm run build`) and `./vendor/bin/phpunit`.
- Keep migrations and seeding changes separate and document them in migration files.
- If touching authentication or social login flows, check `routes/auth.php` and `app/Http/Controllers/AuthController.php`.

If anything in these instructions is unclear or incomplete, please tell me which part you'd like expanded (routing, Volt/Livewire specifics, models, or dev workflow) and I'll update this file.
