# Laravel Starter Strict

A Laravel starter kit with a preconfigured development environment focused on strict standards, automated quality checks, testing, and maintainable application architecture.

## Included Tools

- Laravel Pint
- Pest
- Larastan
- PHPStan
- Pest Type Coverage
- Custom Artisan generators

---

## Installation

```bash
composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

```

# Development Commands

## Run Full Test Suite

Run all quality checks:

```bash
composer test
```

---

## Run Tests

```bash
composer test:unit
```

---

## Run Type Coverage

```bash
composer test:type-coverage
```

---

## Run Pint

Format the codebase:

```bash
composer lint
```

Check formatting without modifying files:

```bash
composer test:lint
```

---

## Run PHPStan / Larastan

Run static analysis:

```bash
composer phpstan
```

---

# Custom Artisan Commands

## Create Action

Create a new action class:

```bash
php artisan make:action CreateUserAction
```

Creates:

```
app/
└── Actions/
    └── CreateUserAction.php
```

Nested actions are supported:

```bash
php artisan make:action User/CreateUserAction
```

Creates:

```
app/
└── Actions/
    └── User/
        └── CreateUserAction.php
```

---

# Application Structure

The starter includes the following application folders:

```
app/
├── Actions
├── DTOs
├── Enums
├── Exceptions
├── Services
└── Support
```

---

# Code Quality Workflow

Before committing changes, run:

```bash
composer test
```

All code should pass:

- Pest
- Type Coverage
- Pint
- PHPStan
