# E-Commerce Application

## Overview

This is a full-featured e-commerce application built with Laravel. It provides a complete solution for online shopping with separate user and admin interfaces, product management, shopping cart functionality, checkout process, and order management.

## Features

### User Features

-   **User Authentication**: Register, login, and manage user accounts
-   **Product Browsing**: Browse products by category with filtering options
-   **Shopping Cart**: Add, update, and remove products from cart
-   **Checkout Process**: Complete purchases with shipping and payment information
-   **Order Tracking**: View order history and status
-   **Email Notifications**: Receive welcome emails and order confirmations

### Admin Features

-   **Admin Dashboard**: Overview of sales, orders, and user activity
-   **Product Management**: Add, edit, and delete products
-   **Category Management**: Create and manage product categories
-   **Order Management**: View and update order status
-   **User Management**: Manage user accounts and roles
-   **Content Management**: Manage static blocks and page content

## Technology Stack

-   **Backend**: Laravel 12.x
-   **Database**: MySQL
-   **Frontend**: Blade templates, JavaScript
-   **Authentication**: Laravel's built-in authentication system with multi-guard support

## Installation

### Prerequisites

-   PHP >= 8.2
-   Composer
-   MySQL or compatible database
-   Node.js and NPM (for frontend assets)

### Setup Instructions

1. Clone the repository:

    ```
    git clone <repository-url>
    cd ecommerce
    ```

2. Install PHP dependencies:

    ```
    composer install
    ```

3. Install JavaScript dependencies:

    ```
    npm install
    ```

4. Create a copy of the environment file:

    ```
    cp .env.example .env
    ```

5. Generate application key:

    ```
    php artisan key:generate
    ```

6. Configure your database in the `.env` file:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

7. Run database migrations and seeders:

    ```
    php artisan migrate --seed
    ```

8. Build frontend assets:

    ```
    npm run dev
    ```

9. Start the development server:

    ```
    php artisan serve
    ```

10. Access the application at `http://localhost:8000`

## Email Configuration

### Mailtrap Setup (Development)

1. Create a [Mailtrap](https://mailtrap.io/) account if you don't have one
2. Create a new inbox in your Mailtrap account
3. Copy the SMTP credentials from your Mailtrap inbox
4. Update your `.env` file with the following settings:

```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@ecommerce.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Email Features

-   **Welcome Email**: Sent to users upon registration
-   **Order Confirmation Email**: Sent to users after order placement

## Usage

### User Interface

-   **Homepage**: Browse featured products and categories
-   **Shop**: View all products with filtering options
-   **Product Details**: View detailed product information
-   **Cart**: Manage items in your shopping cart
-   **Checkout**: Complete your purchase
-   **User Profile**: Manage your account and view order history

### Admin Interface

-   **Dashboard**: Access at `/admin`
-   **Products**: Manage product listings
-   **Categories**: Organize products into categories
-   **Orders**: View and manage customer orders
-   **Users**: Manage user accounts
-   **Content**: Manage static blocks and page content

## Development

### Key Components

-   **Models**: Located in `app/Models/`
-   **Controllers**: Located in `app/Http/Controllers/`
-   **Views**: Located in `resources/views/`
-   **Routes**: Defined in `routes/web.php` and `routes/user.php`
-   **Services**: Located in `app/Services/`

### Multi-Guard Authentication

The application uses Laravel's multi-guard authentication to separate user and admin access:

-   **User Guard**: For regular customers
-   **Admin Guard**: For administrative access

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature-name`
3. Commit your changes: `git commit -m 'Add some feature'`
4. Push to the branch: `git push origin feature-name`
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.
