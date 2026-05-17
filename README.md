## Project Overview

Sebanow is an on-demand home service multi-vendor marketplace built with Laravel. It supports admin users, service providers, and customers, with profile management, document support, and payment gateway integration.

This repository is developed as a university Software Project Design and Development project.

## Key Features

- Multi-role marketplace for on-demand home services
- Admin dashboard and profile management
- Customer account and service booking flow
- Provider profile management, document uploads, and approval workflows
- Phone input validation with Bangladesh default country code
- Soft delete support for user documents
- Modular architecture using `nwidart/laravel-modules`
- Payment gateway and external service integration
- File uploads for profile and business assets
- Laravel Sanctum authentication and optional social login support

## Technology Stack

- PHP 8.3
- Laravel 12
- Blade templates
- Vite + Axios for frontend tooling
- MySQL / MariaDB
- Laravel Sanctum and Socialite
- Eloquent ORM, migrations, and seeders
- Modular code structure with `nwidart/laravel-modules`

## Repository Structure

- `app/` — application source code
- `bootstrap/` — framework bootstrap files
- `config/` — application configuration
- `database/` — migrations, seeders, and factories
- `Modules/` — modular app code
- `public/` — public assets
- `resources/` — Blade views, JS, and CSS
- `routes/` — route definitions
- `storage/` — logs, compiled views, and uploads
- `tests/` — automated tests

## Installation

1. Clone the repository:
   ```bash
   git clone <repo-url> sebanow
   cd sebanow
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install Node dependencies:
   ```bash
   npm install
   ```
4. Configure environment:
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```
5. Update `.env` credentials:
   - `DB_DATABASE`
   - `DB_USERNAME`
   - `DB_PASSWORD`
   - payment gateway keys
   - Firebase and SMS provider settings
6. Run database migrations:
   ```bash
   php artisan migrate
   ```
7. Build frontend assets:
   ```bash
   npm run dev
   ```
8. Serve the application:
   ```bash
   php artisan serve
   ```

## Development Notes

- Phone inputs use country code selection and default to Bangladesh (`bd`).
- Profile pages should show the correct `username` field.
- `user_documents` uses soft deletes via `deleted_at`.
- The app is organized in modules for provider, customer, and admin features.

## Usage

- Admins manage platform settings, providers, and customers.
- Customers request services, manage profiles, and view bookings.
- Providers manage offerings, documents, and bookings.

## License

This project is released under the MIT License.

## University Project

This repository is completed as part of a university-level Software Project Design and Development course.
