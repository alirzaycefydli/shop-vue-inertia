# Testing

The application uses **Pest** for automated testing.

Tests are organized into two main categories: Feature Tests and Unit Tests.

## Testing Structure

```text
tests/
├── Feature/
│   ├── Auth/
│   ├── Cart/
│   ├── Checkout/
│   ├── Products/
│   └── ...
└── Unit/
│   ├── Enums/
│   └── ...
```

### Feature Tests

Feature tests verify that different parts of the application work correctly together.

They cover:
- Authentication and registration.
- Product listing and filtering.
- Category navigation.
- Guest and authenticated cart operations.
- Checkout and order creation.
- Authorization and validation.
- Database interactions and session behavior.

### Unit Tests

Unit tests focus on individual classes and business logic in isolation.

Potential areas include:
- Action classes.
- Product filtering and sorting logic.
- Enums and helper methods.
- Business rules that can be tested independently.

## Testing Approach

Tests should focus primarily on application behavior rather than frontend implementation details.

Important things to verify include:

- Correct database records are created, updated, and deleted.
- Invalid requests are rejected.
- Users cannot access or modify resources belonging to other users.
- Guest sessions contain the expected data.
- Product stock and availability rules are respected.
- Actions return the expected results.
- Authentication and authorization behave correctly.

## Database & Sessions

The test suite uses Laravel's `RefreshDatabase` trait to ensure database isolation between tests.

Session assertions are used to verify guest cart functionality.

Database assertions are preferred when testing persistent application behavior.

## Test Helpers

Common test setup and reusable helper functions can be defined in `tests/Pest.php` to avoid repeating the same setup across multiple tests.

## Running Tests

Run the complete test suite:

```bash
php artisan test
```

Run a specific test file:

```bash
php artisan test tests/Feature/Auth/LoginTest.php
php artisan test LoginTest
```

Run tests with Pest directly:

```bash
./vendor/bin/pest
```

## Code Quality

The project also uses:

- **Pint** – Code formatting.
- **PHPStan / Larastan** – Static analysis and type checking.

These tools complement automated tests by checking code consistency and identifying potential errors.