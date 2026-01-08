# ----------- Stage 1: Build Frontend & Composer Dependencies -----------
    FROM php:8.2-fpm AS build

    # Force apt to use IPv4
    RUN echo 'Acquire::ForceIPv4 "true";' > /etc/apt/apt.conf.d/99force-ipv4
    
    # Install PHP & Node dependencies
    RUN apt-get update && apt-get install -y \
        git \
        unzip \
        curl \
        libzip-dev \
        libonig-dev \
        zip \
        npm \
        nodejs \
        && docker-php-ext-install pdo pdo_mysql zip
    
    # Install Composer
    COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
    
    # Set working directory
    WORKDIR /var/www/html
    
    # Copy the entire project before composer install
    COPY . .
    
    # Allow Composer to run as root (inside Docker)
    ENV COMPOSER_ALLOW_SUPERUSER=1
    
    # Install PHP dependencies
    RUN composer install --no-dev --optimize-autoloader
    
    # Install Node dependencies & build Vue assets
    RUN npm install
    RUN npm run build
    
    # ----------- Stage 2: Production Image -----------
    FROM php:8.2-fpm
    
    # Force IPv4 again
    RUN echo 'Acquire::ForceIPv4 "true";' > /etc/apt/apt.conf.d/99force-ipv4
    
    # Install PHP extensions required
    RUN apt-get update && apt-get install -y \
        libzip-dev \
        unzip \
        git \
        && docker-php-ext-install pdo pdo_mysql zip
    
    # Set working directory
    WORKDIR /var/www/html
    
    # Copy project from build stage
    COPY --from=build /var/www/html /var/www/html
    
    # Set proper permissions
    RUN chown -R www-data:www-data /var/www/html \
        && chmod -R 755 /var/www/html/storage
    
    # Run PHP-FPM
    CMD ["php-fpm"]
    