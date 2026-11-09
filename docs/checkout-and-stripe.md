# Checkout & Stripe

The application uses Stripe Checkout to process payments. Both guest and authenticated users can complete purchases through the same checkout flow.

## Architecture

- **Checkout:** Handles the checkout page and prepares the required data.
- **StripePaymentService:** Handles communication with the Stripe API.
- **CreateOrder:** Creates an order in the database.
- **Webhook:** Handles Stripe payment events and updates order status.

## Checkout Flow

1. User proceeds to checkout from the cart.
2. Cart products are retrieved and normalized.
3. User selects or provides a delivery address.
4. Order totals and delivery costs are calculated.
5. Stripe Checkout Session is created.
6. User is redirected to Stripe to complete payment.
7. Stripe redirects the user back to the application.

Both guest and authenticated cart data use the same normalized structure to keep checkout logic consistent.

## Stripe Integration

Stripe integration is handled through `StripePaymentService`, which uses the Stripe PHP SDK.

The service is responsible for creating Stripe Checkout Sessions and preparing payment information.

Stripe configuration is stored in `config/services.php`, using environment variables:

```env
STRIPE_KEY=
STRIPE_SECRET=
STRIPE_WEBHOOK_SECRET=
```

## Orders

Orders are stored in the database and associated with users when applicable.

Main order information includes:

- UUID as the primary identifier.
- Nullable `user_id` for guest orders.
- `order_number`.
- Payment status (`Pending`, `Paid`).
- Order totals and currency.
- Stripe Checkout Session ID.
- Delivery and billing address references.

An order is initially created with a `Pending` status.

## Webhooks

Stripe webhooks are used to confirm successful payments.

When Stripe sends a successful checkout event:

1. The corresponding order is identified using the Stripe Checkout Session ID.
2. The order status is updated from `Pending` to `Paid`.
3. Customer email information is retrieved from Stripe's customer details.

Webhook handling is important because payment confirmation should come from Stripe rather than relying only on the user's browser redirect.

## Events & Emails

After successful payment processing queued listener to send order-related email notifications.

The email queue is named `orders`.

## Important Considerations

- Never trust cart prices or totals submitted by the frontend.
- Validate product availability and stock before creating a checkout session.
- Guest orders must be supported without requiring a `user_id`.
- Stripe webhooks should be used as the source of truth for payment confirmation.
- Prevent duplicate payment processing when handling repeated webhook events.
- Do not mark an order as paid based only on a successful browser redirect.