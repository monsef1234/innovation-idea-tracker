FROM php:8.2-cli

# System deps
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build

RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear

EXPOSE 8080

CMD php artisan migrate --force \
 && php artisan serve --host=0.0.0.0 --port=8080
