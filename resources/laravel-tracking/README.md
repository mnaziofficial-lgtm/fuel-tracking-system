# Laravel Tracking Project

## Overview
The Laravel Tracking Project is a web application designed to manage sales and fuel stock efficiently. It provides an admin dashboard for monitoring sales, fuel types, and stock levels, along with functionalities for managing pumps and sales records.

## Features
- **Admin Dashboard**: View total sales, fuel stock, and recent activity.
- **Sales Management**: Track sales records with detailed information.
- **Fuel Management**: Manage fuel types and stock levels.
- **User Authentication**: Secure login and registration for users.

## Project Structure
```
laravel-tracking
├── app
│   ├── Http
│   │   ├── Controllers
│   │   │   └── AdminController.php
│   │   └── Middleware
│   └── Models
├── bootstrap
├── config
├── database
│   ├── migrations
│   └── seeders
├── public
│   ├── css
│   │   └── styles.css
│   ├── js
│   │   └── app.js
│   └── index.php
├── resources
│   ├── views
│   │   ├── layouts
│   │   │   └── app.blade.php
│   │   ├── components
│   │   │   ├── header.blade.php
│   │   │   └── footer.blade.php
│   │   ├── admin
│   │   │   ├── dashboard.blade.php
│   │   │   ├── pumps.blade.php
│   │   │   └── sales.blade.php
│   │   └── auth
│   │       ├── login.blade.php
│   │       └── register.blade.php
│   ├── css
│   │   └── app.css
│   └── js
│       └── app.js
├── routes
│   └── web.php
├── package.json
├── vite.config.js
├── composer.json
├── .env.example
└── README.md
```

## Installation
1. Clone the repository:
   ```
   git clone <repository-url>
   ```
2. Navigate to the project directory:
   ```
   cd laravel-tracking
   ```
3. Install dependencies:
   ```
   composer install
   npm install
   ```
4. Set up your environment file:
   ```
   cp .env.example .env
   ```
5. Generate the application key:
   ```
   php artisan key:generate
   ```
6. Run migrations to set up the database:
   ```
   php artisan migrate
   ```
7. Start the development server:
   ```
   php artisan serve
   ```

## Usage
- Access the application at `http://localhost:8000`.
- Use the admin dashboard to manage sales and fuel stock.
- Log in or register to access user-specific functionalities.

## Contributing
Contributions are welcome! Please open an issue or submit a pull request for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for details.