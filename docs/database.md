# Database Structure

## Entity Relationship Diagram

```mermaid
erDiagram
    USERS ||--o| CARTS : has
    USERS ||--o| WISHLISTS : has
    CARTS ||--o{ CART_ITEMS : contains
    PRODUCTS ||--o{ CART_ITEMS : included_in
    PRODUCTS ||--o| PRODUCT_IMAGES: has

    USERS ||--o{ ORDERS : places
    ORDERS ||--|{ ORDER_ITEMS : contains
    PRODUCTS ||--o{ ORDER_ITEMS : referenced_by

    USERS ||--o{ ADDRESSES : owns

    CATEGORIES ||--o{ PRODUCTS : categorizes

    USERS {
        uuid id PK
        string name
        string email
    }

    PRODUCTS {
        uuid id PK
        uuid primary_category_id FK
        string name
        string slug
        decimal price
        integer stock_quantity
    }

    ORDERS {
        uuid id PK
        uuid user_id FK
        string order_number
        string status
        decimal total
        string session_id
    }

    ORDER_ITEMS {
        uuid id PK
        uuid order_id
        uuid product_id
        string product_name
        integer quantity
        decimal unit_price
        decimal subtotal
    }

    WISHLISTS {
        uuid id PK
        uuid product_id
        uuid user_id
    }

    PRODUCT_IMAGES {
        uuid id PK
        string image_url
        integer position
    }

    CATEGORIES {
        uuid id PK
        uuid parent_id
        string name
        string slug
    }

    CARTS {
        uuid id PK
        uuid user_id
    }

    CART_ITEMS {
        uuid id PK
        uuid cart_id
        uuid product_id
        integer quantity
    }

    ADDRESSES {
        uuid id PK
        uuid user_id
        string alias
        string name
        string address
        string city
        string postal_code
        string country
    }
```

## Main Relationships

- A user can have a cart.
- A cart contains multiple cart items.
- Products can belong to categories.
- An order contains multiple order items.
- An order can belong to a registered user.
- A user can wishlist items.