# Elite Grooming Studios

A comprehensive web application for managing a professional grooming studio, combining appointment booking and e-commerce functionality.

## Overview

Elite Grooming Studios is a full-featured web application that provides both service booking capabilities and an online store for grooming products. The platform serves both customers and administrators with an intuitive interface and robust backend functionality.

## Features

### For Customers
- **User Account Management**
  - Registration and login
  - Profile management
  - Order history
  - Appointment tracking

- **Appointment Booking**
  - Easy-to-use booking interface
  - Service selection
  - Date and time preferences
  - Appointment status tracking

- **Online Store**
  - Browse grooming products
  - Shopping cart functionality
  - Secure checkout with Stripe
  - Guest checkout option
  - Order tracking

### For Administrators
- **User Management**
  - Customer account oversight
  - Role-based access control
  - Account activation/deactivation

- **Appointment Management**
  - View and manage appointments
  - Update appointment status
  - Schedule management

- **Inventory Management**
  - Product management
  - Stock tracking
  - Price updates
  - Image management

- **Order Processing**
  - Order management
  - Status updates
  - Customer communication

## Tech Stack

- **Backend**
  - PHP 8.2+
  - MySQL 8.2+
  - Apache/Nginx web server

- **Frontend**
  - HTML5
  - CSS3
  - JavaScript
  - Custom responsive design

- **Dependencies**
  - Stripe PHP SDK (Payment processing)
  - PHPMailer (Email notifications)

## Installation

1. **Clone the repository**
   ```bash
   git clone [repository-url]
   cd Elite-Grooming-Studios
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Database setup**
   - Create a MySQL database
   - Import the `egs.sql` file
   - Configure database connection in `secrets.php`

4. **Configuration**
   - Copy `secrets.php.example` to `secrets.php` (if not exists)
   - Update database credentials
   - Configure Stripe API keys
   - Set up email settings

5. **Web server configuration**
   - Point your web server to the project directory
   - Ensure the `.htaccess` file is properly configured
   - Set appropriate permissions for uploads directory

## Configuration

Create a `secrets.php` file in the root directory with the following structure:

```php
<?php
define('DB_HOST', 'your_host');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

define('STRIPE_SECRET_KEY', 'your_stripe_secret_key');
define('STRIPE_PUBLISHABLE_KEY', 'your_stripe_publishable_key');

define('SMTP_HOST', 'your_smtp_host');
define('SMTP_USER', 'your_smtp_username');
define('SMTP_PASS', 'your_smtp_password');
define('SMTP_PORT', 587);
```

## Usage

### Customer Interface
1. Visit the website
2. Create an account or browse as a guest
3. Book appointments or shop for products
4. Manage appointments and orders through the dashboard

### Admin Interface
1. Login with admin credentials
2. Access the admin panel through `/admin`
3. Manage users, appointments, products, and orders
4. View reports and analytics

## Security Features

- Password hashing using BCRYPT
- Session management
- SQL injection prevention
- XSS protection
- CSRF protection
- Secure payment processing

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is proprietary software. All rights reserved.

## Support

For support, please email [support@elitegroomingstudios.com](mailto:support@elitegroomingstudios.com)