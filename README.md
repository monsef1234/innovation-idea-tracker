# Innovation Idea Tracker

A modern web application for submitting ideas, voting, and providing feedback, built with Laravel and Vue.js.

## Table of Contents

1. [User Guide](#user-guide)

    - [Getting Started](#getting-started)
    - [User Roles](#user-roles)
    - [Submitting Ideas](#submitting-ideas)
    - [Voting](#voting)
    - [Providing Feedback](#providing-feedback)
    - [Website Feedback](#website-feedback)

2. [Technical Documentation](#technical-documentation)
    - [System Requirements](#system-requirements)
    - [Installation](#installation)
    - [Project Structure](#project-structure)
    - [Environment Configuration](#environment-configuration)
    - [Development Workflow](#development-workflow)
    - [Testing](#testing)
    - [Deployment](#deployment)

## User Guide

### Getting Started

1. **Create an Account**

    - Click on "Sign Up" and fill in your details
    - **Select your role** during signup:
        - **Submitter**: Can submit ideas and comment
        - **Reviewer**: Can submit ideas, vote, and comment
    - Log in with your credentials

2. **Default Admin Account**
    - Email: `admin@example.com`
    - Password: `password`
    - Admins have full access to all features

### User Roles

The application has three user roles with different permissions:

| Feature                | Submitter | Reviewer | Admin |
| ---------------------- | --------- | -------- | ----- |
| Submit Ideas           | ✅        | ✅       | ✅    |
| Comment on Ideas       | ✅        | ✅       | ✅    |
| Vote (Upvote/Downvote) | ❌        | ✅       | ✅    |
| View Feedbacks         | ❌        | ❌       | ✅    |
| Manage All Content     | ❌        | ❌       | ✅    |

### Submitting Ideas

1. Click on "Submit Idea" in the navigation bar
2. Fill in the following details:
    - **Title**: Brief description of your idea
    - **Detailed description**: Explain your idea in detail
    - **Category**: Select from available options
3. Click "Submit" to post your idea

### Voting

> **Note**: Only users with the **Reviewer** or **Admin** role can vote.

1. Browse through the list of ideas on the home page
2. For each idea, you can:
    - **Upvote** (👍 Vote button) ideas you support
    - **Downvote** (👎 button) ideas you don't support
    - View the **vote count** displayed between the buttons
3. Your active votes are highlighted in green (upvote) or red (downvote)
4. Click the same vote button again to remove your vote

### Providing Feedback

**Coming Soon**: Comment functionality will be available in a future update.

### Website Feedback

You can provide feedback about the website itself:

1. Look for the **feedback button** in the **bottom right corner** of any page
2. Click it to open the feedback form
3. Submit your suggestions or report issues
4. **Admins** can view all submitted feedback through the admin panel

## Technical Documentation

### System Requirements

-   PHP 8.1 or higher
-   Composer 2.x
-   Node.js 16+ and NPM
-   MySQL 5.7+ or MariaDB 10.3+
-   Web server (Apache/Nginx)
-   Redis (optional, for caching and queues)

### Installation

1. **Clone the repository**

    ```bash
    git clone [repository-url]
    cd vote-app
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install JavaScript dependencies**

    ```bash
    npm install
    ```

4. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Configure database**

    - Update `.env` with your database credentials:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=vote_app
        DB_USERNAME=root
        DB_PASSWORD=
        ```
    - Run migrations and seeders:
        ```bash
        php artisan migrate --seed
        ```

6. **Compile assets**

    ```bash
    # For development
    npm run dev

    # For production
    npm run build
    ```

7. **Start the development server**

    ```bash
    php artisan serve
    ```

    Access the application at `http://localhost:8000`

### Project Structure

```
vote-app/
├── app/                  # Application code
│   ├── Http/            # Controllers and middleware
│   │   ├── Controllers/ # Request handlers
│   │   └── Middleware/  # HTTP middleware
│   ├── Models/          # Eloquent models
│   │   ├── User.php
│   │   ├── Idea.php
│   │   ├── Vote.php
│   │   └── Feedback.php
│   └── ...
├── config/              # Configuration files
├── database/            # Migrations and seeders
│   ├── migrations/      # Database schema
│   └── seeders/         # Seed data
├── public/              # Publicly accessible files
├── resources/
│   ├── js/              # Vue.js components
│   │   ├── Pages/       # Inertia.js pages
│   │   ├── Layouts/     # Layout components
│   │   └── Components/  # Reusable components
│   └── views/           # Blade templates
├── routes/              # Application routes
│   ├── web.php         # Web routes
│   └── api.php         # API routes
├── package.json         # NPM dependencies
├── composer.json        # PHP dependencies
├── vite.config.js      # Vite configuration
└── tailwind.config.js  # Tailwind CSS configuration
```

### Technology Stack

-   **Backend**: Laravel 10+ (PHP Framework)
-   **Frontend**: Vue.js 3 with TypeScript
-   **Routing**: Inertia.js (SPA without API)
-   **Styling**: Tailwind CSS + DaisyUI
-   **Build Tool**: Vite
-   **Database**: MySQL/MariaDB
-   **ORM**: Eloquent

### Environment Configuration

Key environment variables in `.env`:

```env
APP_NAME="Innovation Idea Tracker"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vote_app
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Session & Cache
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

## Features Overview

### Current Features

-   ✅ User registration and authentication with role selection
-   ✅ Three-tier role system (Admin, Reviewer, Submitter)
-   ✅ Idea submission with title, description, and category
-   ✅ Voting system (upvote/downvote) for Reviewers and Admins
-   ✅ Real-time vote count display
-   ✅ Infinite scroll for idea listings
-   ✅ Website feedback submission
-   ✅ Admin dashboard for viewing feedbacks
-   ✅ Flash messages for user actions
-   ✅ Responsive design with DaisyUI

### Planned Features

-   🔜 Comment system on ideas
-   🔜 Idea status management (pending, approved, implemented)
-   🔜 User notifications
-   🔜 Search and filter ideas
-   🔜 Tagging system
-   🔜 User profile pages
-   🔜 Activity history

## Troubleshooting

### Common Issues

1. **"Target class [Controller] does not exist"**

    - Run: `composer dump-autoload`

2. **Vite manifest not found**

    - Run: `npm run build` or ensure `npm run dev` is running

3. **Permission denied errors**

    ```bash
    chmod -R 775 storage bootstrap/cache
    chown -R www-data:www-data storage bootstrap/cache
    ```

4. **Database connection refused**
    - Check if MySQL is running: `sudo service mysql status`
    - Verify `.env` database credentials

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues and questions:

-   Open an issue on GitHub
-   Use the website feedback feature
-   Contact the admin at admin@example.com
