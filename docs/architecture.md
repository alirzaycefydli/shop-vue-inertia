# Application Architecture

## Overview

This application is built using Laravel 13, Inertia.js, Vue 3, and JavaScript. It follows a server-driven architecture where Laravel handles business logic, database operations, authentication, and application workflows, while Vue 3 provides the frontend interface through Inertia.js.

The application uses an action-oriented approach to organize business logic into small, reusable classes.

## Technology Stack

- **Backend:** Laravel 13
- **Frontend:** Vue 3
- **Frontend integration:** Inertia.js
- **UI components:** Nuxt UI
- **Database:** Relational database with Eloquent ORM
- **Payments:** Stripe Checkout
- **Testing:** Pest
- **Code quality:** PHPStan, Larastan, Laravel Pint

## Application Structure

The backend is organized around the following components:

### Controllers

Controllers handle incoming HTTP requests, validate input, invoke the appropriate application actions, and return responses.

They act as the entry point between HTTP requests and application logic.

Controllers should remain relatively lightweight. Business logic is delegated to action classes rather than implemented directly inside controllers.

### Actions

Actions contain specific application operations and business logic.

Each action is responsible for a particular task, making the code easier to maintain, reuse, and test.

Examples include:

- `CreateOrder` – creates an order and its associated records.
- `AllProducts` – retrieves products.
- `ProductsByCategory` – retrieves products belonging to a category and its descendants.
- `CreateStripeCheckout` – coordinates order creation and Stripe Checkout session creation.
- `AllCartProducts` – retrieves products belonging to a user's cart.

Actions can receive dependencies through Laravel's service container and constructor injection.

### Services

Services encapsulate integrations or functionality that interacts with external systems.

For example, `StripePaymentService` handles communication with the Stripe SDK and creates Checkout sessions.

The application uses a `StripePaymentGateway` interface to decouple checkout business logic from the Stripe implementation. This also makes it possible to replace the real payment gateway with a mock during testing.

### Models

Eloquent models represent the application's database entities and relationships.

Main models include:

- `User`
- `Product`
- `Product Image`
- `Category`
- `Cart`
- `CartItem`
- `Order`
- `OrderItem`
- `Address`
- `Whislist`

Models are responsible for database relationships, attribute casting, and model-level functionality.

UUIDs are used as model identifiers.

### Resources

Laravel API resources are used to transform application data into structured frontend data.

For example, cart resources provide a consistent data structure for frontend components, while separate resources can accommodate guest and authenticated cart data.

### Middleware and Shared Inertia Data

Inertia middleware shares application-wide data with frontend pages.

This allows commonly used information, such as navigation categories and authenticated user information, to be accessed by Vue components without repeatedly passing the same data through individual controllers.

## Main Application Workflows

### Product Catalog

1. A user visits a product or category page.
2. The controller receives the request.
3. Relevant actions retrieve products and categories.
4. Product resources transform the data.
5. The controller returns an Inertia response.
6. Vue renders the page.

Category filtering supports hierarchical categories, allowing products from descendant categories to be included.

### Shopping Cart

The application supports both guest and authenticated shopping carts.

**Guest users:**
- Cart data is stored in the session.
- Product information is retrieved from the database.
- Cart data is transformed into a consistent structure for frontend use.

**Authenticated users:**
- Cart data is stored in the database.
- Cart items are associated with the user's cart.
- Ownership checks prevent users from modifying another user's cart.

Both cart implementations are prepared for a consistent checkout workflow.

### Checkout and Payments

The checkout process is coordinated by the `CreateStripeCheckout` action.

The workflow is:

1. Retrieve checkout items.
2. Create an order and its order items.
3. Prepare Stripe line items using database product prices.
4. Request a Stripe Checkout session through the payment gateway.
5. Save the returned Stripe session ID on the order.
6. Return the session information to the frontend.

The application does not trust prices submitted by the frontend. Product prices are retrieved from the database when preparing the order and Stripe line items.

### Stripe Webhooks

Stripe sends webhook requests to the application when payment events occur.

The webhook endpoint:

1. Reads the raw request payload.
2. Verifies the Stripe signature.
3. Identifies the event type.
4. Finds the corresponding order using the Stripe session ID.
5. Updates the order status when payment is successfully completed.
6. Saves the customer's email address.
7. Initiates the order confirmation email workflow.

Orders are initially created with a pending status and updated to paid after successful payment confirmation. Webhook is used to update the payment status to make sure that order marked as paid after successful payment. Not only after user is redirected to successful payment page.

## Testing

The application uses Pest for automated testing.

Tests are organized into two main categories:

- **Feature tests:** Test complete application workflows, HTTP endpoints, authentication, cart operations, checkout, and webhook handling.
- **Unit tests:** Test isolated application logic, such as individual actions and services.

External integrations, such as Stripe, are mocked where appropriate to avoid making real API requests during automated tests.

## Design Principles

The application follows several principles:

- Separation of concerns between controllers, actions, services, and models.
- Dependency injection through Laravel's service container.
- Interface-based abstraction for external payment integrations.
- Reusable application actions.
- Database-backed validation of important business data.
- Automated testing of application workflows.
- Consistent data structures between frontend and backend.