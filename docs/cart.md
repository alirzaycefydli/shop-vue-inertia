# Cart

The cart system supports both guest and authenticated users. Each type uses a different storage mechanism, but both provide a normalized cart structure for shared functionality, especially during checkout.

## Architecture

- **Guest users:** Cart is stored in the Laravel session.
- **Authenticated users:** Cart is stored in the database using `Cart` and `CartItem` models.
- **Cart actions:** Business logic is handled through dedicated action classes.
- **Cart resources:** Cart data is normalized before being shared with the frontend and checkout process.

## Guest Cart

Guest cart data is stored in the session under the `cart` key.

Each cart item contains:
- `product_id`
- `quantity`

Guest cart operations include:
- Adding products.
- Updating quantities.
- Removing products.
- Retrieving cart products.

## Authenticated Cart

Authenticated users have a database-backed cart.

- Each user has their own cart.
- Cart items are associated with products.
- Cart operations are restricted to the cart owner.
- Product availability and stock quantities are validated when modifying the cart.

## Cart Actions

Business logic is separated into action classes.

Some of the main actions include:

- `CreateCartItem` – Adds a product or updates its quantity.
- `AllCartProducts` – Retrieves the products belonging to the cart.
- `CreateCart` – Creates a cart for an authenticated user.

## Cart Data Structure

Guest and authenticated cart items are normalized into a shared structure to avoid duplicating checkout logic.

Normalized cart item structure:

```php
[
    'id' => $cartItemId,
    'quantity' => 2,
    'product' => [
        'name' => 'Product name',
        'slug' => 'product-slug',
        'price' => 29.99,
        'image' => 'product-image.jpg',
    ],
]
```

The structure allows both guest and authenticated carts to use the same checkout flow.

## Checkout Integration

Cart products are passed to the checkout process, where they are used to calculate totals and generate Stripe Checkout line items.

Guest and authenticated users share the same checkout logic through their normalized cart data.

An empty or invalid cart cannot proceed to checkout.

## Testing

Important cart scenarios to cover:

- Adding products as a guest.
- Adding products as an authenticated user.
- Updating product quantities.
- Removing cart items.
- Preventing quantities from exceeding available stock.
- Preventing inactive products from being added.
- Preventing users from modifying another user's cart.
- Retrieving the correct cart for each user.
- Ensuring guest and authenticated cart data have the expected structure.
- Preventing checkout with an empty cart.