# Email Notification System

## Overview

This document outlines the email notification system implemented in the e-commerce application. The system sends emails to users when they register and when they place orders.

## Features

-   Welcome email sent to users upon registration
-   Order confirmation email sent when an order is successfully placed

## Implementation Details

### Email Classes

-   `WelcomeEmail`: Sent to users after registration
-   `OrderConfirmationEmail`: Sent to users after order placement

### Email Templates

-   `emails/welcome.blade.php`: Template for welcome emails
-   `emails/order-confirmation.blade.php`: Template for order confirmation emails

### Integration Points

-   `RegisterController`: Sends welcome email after user creation
-   `CheckoutService`: Sends order confirmation email after successful order processing

## Setup Instructions

### Mailtrap Configuration

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

5. Make sure your application's `config/mail.php` is configured to use these environment variables

### Testing Emails

1. Register a new user to test the welcome email
2. Place an order to test the order confirmation email
3. Check your Mailtrap inbox to view the sent emails

## Troubleshooting

-   If emails are not appearing in Mailtrap, check your `.env` configuration
-   Verify that the SMTP credentials are correct
-   Check the Laravel logs for any mail-related errors
-   Ensure that the `MAIL_MAILER` is set to `smtp` and not `log` in your environment
