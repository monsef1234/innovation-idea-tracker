FROM php:8.2-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev curl \
    && docker-php-ext-install pdo pdo_pgsql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node.js + npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www
COPY . .

# PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# JS dependencies + build
RUN npm install && npm run build

# Clear cache
RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=8080
