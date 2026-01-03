# Vote App

A modern web application for submitting ideas, voting, and providing feedback, built with Laravel and Vue.js.

## Table of Contents

1. [User Guide](#user-guide)

    - [Getting Started](#getting-started)
    - [Submitting Ideas](#submitting-ideas)
    - [Voting](#voting)
    - [Providing Feedback](#providing-feedback)
    - [User Account](#user-account)

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
    - Verify your email address
    - Log in with your credentials

2. **Dashboard**
    - View all active ideas
    - See top-voted ideas
    - Check your activity feed

### Submitting Ideas

1. Click on "Submit Idea" in the navigation bar
2. Fill in the following details:
    - Title (brief description of your idea)
    - Detailed description
    - Category (select from available options)
    - Any relevant tags
3. Click "Submit" to post your idea

### Voting

1. Browse through the list of ideas
2. For each idea, you can:
    - Upvote (thumbs up) ideas you support
    - Downvote (thumbs down) ideas you don't support
    - View the number of votes each idea has received

### Providing Feedback

1. Navigate to any idea's detail page
2. Scroll to the comments section
3. Type your feedback in the text box
4. Click "Post Comment" to submit

### User Account

-   **Profile**: View and edit your profile information
-   **My Ideas**: See all ideas you've submitted
-   **Votes**: Track ideas you've voted on
-   **Notifications**: Get updates on your ideas and comments

## Technical Documentation

### System Requirements

-   PHP 8.1 or higher
-   Composer
-   Node.js 16+ and NPM
-   MySQL 5.7+ or MariaDB 10.3+
-   Web server (Apache/Nginx)
-   Redis (for caching and queues)

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

    - Update `.env` with your database credentials
    - Run migrations and seeders:
        ```bash
        php artisan migrate --seed
        ```

6. **Compile assets**

    ```bash
    npm run build
    ```

7. **Start the development server**
    ```bash
    php artisan serve
    ```

### Project Structure

```
vote-app/
├── app/                  # Application code
│   ├── Http/            # Controllers and middleware
│   ├── Models/           # Eloquent models
│   └── ...
├── config/               # Configuration files
├── database/             # Migrations and seeders
├── public/               # Publicly accessible files
├── resources/
│   ├── js/               # Vue.js components
│   └── views/            # Blade templates
├── routes/               # Application routes
└── tests/                # Test files
```

### Environment Configuration

Key environment variables in `.env`:

```
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
```

### Development Workflow

1. **Starting the development environment**

    ```bash
    # Start Laravel development server
    php artisan serve

    # Start Vite for frontend assets
    npm run dev
    ```

2. **Running tests**

    ```bash
    # Run PHPUnit tests
    php artisan test

    # Run JavaScript tests
    npm test
    ```

3. **Code style**

    ```bash
    # PHP code style fixer
    composer fix

    # JavaScript code style
    npm run lint
    ```

### Testing

1. **PHP Tests**

    - Unit tests in `tests/Unit`
    - Feature tests in `tests/Feature`
    - Run all tests: `php artisan test`

2. **Browser Tests**
    - Uses Laravel Dusk
    - Configure `.env.dusk.local` for testing environment
    - Run tests: `php artisan dusk`

### Deployment

1. **Production requirements**

    - PHP 8.1+
    - Composer
    - Node.js 16+ and NPM
    - Database server
    - Queue worker (Supervisor recommended)

2. **Deployment steps**

    ```bash
    # Install dependencies
    composer install --optimize-autoloader --no-dev
    npm install --production

    # Optimize application
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    # Compile assets
    npm run build

    # Run migrations
    php artisan migrate --force
    ```

3. **Queue Workers**
   Set up Supervisor to keep the queue worker running:
    ```ini
    [program:vote-app-worker]
    process_name=%(program_name)s_%(process_num)02d
    command=php /path/to/vote-app/artisan queue:work --sleep=3 --tries=3 --max-time=3600
    autostart=true
    autorestart=true
    stopasgroup=true
    killasgroup=true
    user=www-data
    numprocs=8
    redirect_stderr=true
    stdout_logfile=/path/to/vote-app/worker.log
    stopwaitsecs=3600
    ```

## License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
