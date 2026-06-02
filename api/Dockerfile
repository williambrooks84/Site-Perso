FROM php:8.2-fpm

# System deps + PHP extensions
RUN set -eux; \
    apt-get update -o Acquire::Retries=5; \
    apt-get install -y --no-install-recommends \
        libicu-dev \
        libpq-dev \
        libzip-dev \
        libxml2-dev \
        libonig-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        zip \
        unzip \
        git; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j$(nproc) \
        intl pdo pdo_mysql pdo_pgsql zip xml dom opcache gd; \
    rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/api

# Copy only API first (better caching)
COPY . /var/www/html/api

# Install dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

# Fix Symfony writable dirs (IMPORTANT FIX)
RUN mkdir -p var/cache var/log public \
    && chown -R www-data:www-data var public

USER www-data

CMD ["php-fpm"]