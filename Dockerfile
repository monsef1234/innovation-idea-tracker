# ----------- Stage 1: Build Frontend & Composer Dependencies -----------
    FROM php:8.2-fpm AS build

    # Force apt to use IPv4 (حل مشاكل الشبكة)
    RUN echo 'Acquire::ForceIPv4 "true";' > /etc/apt/apt.conf.d/99force-ipv4
    
    # تثبيت الأدوات الأساسية
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
    
    # تثبيت Composer
    COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
    
    # ضبط العمل داخل الحاوية
    WORKDIR /var/www/html
    
    # نسخ ملفات Composer
    COPY composer.json composer.lock ./
    RUN composer install --no-dev --optimize-autoloader
    
    # نسخ باقي ملفات المشروع
    COPY . .
    
    # تثبيت Node dependencies & build Vue assets
    RUN npm install
    RUN npm run build
    
    # ----------- Stage 2: Production Image -----------
    FROM php:8.2-fpm
    
    # Force IPv4 again
    RUN echo 'Acquire::ForceIPv4 "true";' > /etc/apt/apt.conf.d/99force-ipv4
    
    # تثبيت PHP extensions المطلوبة
    RUN apt-get update && apt-get install -y \
        libzip-dev \
        unzip \
        git \
        && docker-php-ext-install pdo pdo_mysql zip
    
    # ضبط العمل داخل الحاوية
    WORKDIR /var/www/html
    
    # نسخ المشروع من مرحلة البناء
    COPY --from=build /var/www/html /var/www/html
    
    # نسخ ملفات built assets (Vue)
    COPY --from=build /var/www/html/public /var/www/html/public
    
    # تغيير صلاحيات
    RUN chown -R www-data:www-data /var/www/html \
        && chmod -R 755 /var/www/html/storage
    
    # تشغيل PHP-FPM
    CMD ["php-fpm"]
    