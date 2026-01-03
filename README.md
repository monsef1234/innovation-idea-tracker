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

### Comment on Ideas

1. Navigate to any idea by clicking on the "💬 Comments" button
2. View existing comments in a threaded format
3. Type your comment in the text box at the bottom
4. Click "Post Comment" to submit your feedback
5. **Reply to comments**: Click "Reply" on any comment to create a threaded response
6. All users (Submitter, Reviewer, and Admin) can comment on ideas

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
├── tests/               # Test files
│   ├── Feature/        # Feature tests
│   └── Unit/           # Unit tests
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

### Development Workflow

1. **Starting the development environment**

    ```bash
    # Terminal 1: Start Laravel development server
    php artisan serve

    # Terminal 2: Start Vite for hot module replacement
    npm run dev
    ```

2. **Database management**

    ```bash
    # Create a new migration
    php artisan make:migration create_table_name

    # Run migrations
    php artisan migrate

    # Rollback migrations
    php artisan migrate:rollback

    # Seed database
    php artisan db:seed

    # Fresh migration with seed
    php artisan migrate:fresh --seed
    ```

3. **Creating components**

    ```bash
    # Create a new controller
    php artisan make:controller IdeaController

    # Create a new model with migration
    php artisan make:model Idea -m

    # Create a new Vue component in resources/js/Components/
    ```

4. **Running tests**

    ```bash
    # Run all PHPUnit tests
    php artisan test

    # Run specific test file
    php artisan test tests/Feature/IdeaTest.php

    # Run with coverage
    php artisan test --coverage
    ```

5. **Code style**

    ```bash
    # PHP code style (if configured)
    ./vendor/bin/pint

    # JavaScript/Vue linting
    npm run lint

    # Type checking
    npm run type-check
    ```

### Testing

1. **PHP Tests**

    - Unit tests in `tests/Unit/`
    - Feature tests in `tests/Feature/`
    - Run all tests: `php artisan test`
    - Example test structure:
        ```php
        public function test_user_can_vote_on_idea()
        {
            $user = User::factory()->create(['role' => 'reviewer']);
            $idea = Idea::factory()->create();

            $response = $this->actingAs($user)
                ->post("/ideas/{$idea->id}/vote", [
                    'vote_type' => 'up'
                ]);

            $response->assertRedirect();
            $this->assertDatabaseHas('votes', [
                'user_id' => $user->id,
                'idea_id' => $idea->id,
                'vote_type' => 'up'
            ]);
        }
        ```

2. **Browser Tests** (Optional)
    - Uses Laravel Dusk
    - Configure `.env.dusk.local` for testing environment
    - Run tests: `php artisan dusk`

### Deployment

1. **Production requirements**

    - PHP 8.1+ with required extensions
    - Composer 2.x
    - Node.js 16+ and NPM
    - MySQL/MariaDB database server
    - Queue worker (Supervisor recommended)
    - HTTPS certificate (Let's Encrypt recommended)

2. **Deployment steps**

    ```bash
    # Pull latest code
    git pull origin main

    # Install dependencies
    composer install --optimize-autoloader --no-dev
    npm install --production

    # Run migrations
    php artisan migrate --force

    # Clear and cache configuration
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    # Compile assets for production
    npm run build

    # Set proper permissions
    chmod -R 755 storage bootstrap/cache
    chown -R www-data:www-data storage bootstrap/cache
    ```

3. **Web server configuration**

    **Nginx example:**

    ```nginx
    server {
        listen 80;
        server_name example.com;
        root /var/www/vote-app/public;

        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-Content-Type-Options "nosniff";

        index index.php;

        charset utf-8;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }

        error_page 404 /index.php;

        location ~ \.php$ {
            fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            include fastcgi_params;
        }

        location ~ /\.(?!well-known).* {
            deny all;
        }
    }
    ```

4. **Queue Workers** (if using queues)

    Set up Supervisor to keep the queue worker running:

    ```ini
    [program:vote-app-worker]
    process_name=%(program_name)s_%(process_num)02d
    command=php /var/www/vote-app/artisan queue:work --sleep=3 --tries=3 --max-time=3600
    autostart=true
    autorestart=true
    stopasgroup=true
    killasgroup=true
    user=www-data
    numprocs=8
    redirect_stderr=true
    stdout_logfile=/var/www/vote-app/storage/logs/worker.log
    stopwaitsecs=3600
    ```

5. **Environment variables for production**

    ```env
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://your-domain.com

    # Use stronger session/cache drivers
    SESSION_DRIVER=redis
    CACHE_DRIVER=redis
    QUEUE_CONNECTION=redis

    # Configure Redis
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    ```

## Features Overview

### Current Features

-   ✅ User registration and authentication with role selection
-   ✅ Three-tier role system (Admin, Reviewer, Submitter)
-   ✅ Idea submission with title, description, and category
-   ✅ Voting system (upvote/downvote) for Reviewers and Admins
-   ✅ Real-time vote count display
-   ✅ Threaded comment system on ideas
-   ✅ Infinite scroll for idea listings
-   ✅ Website feedback submission
-   ✅ Admin dashboard for viewing feedbacks
-   ✅ Flash messages for user actions
-   ✅ Responsive design with DaisyUI

### Planned Features

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
