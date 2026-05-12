# Use the official PHP 8.2 FPM image with extensions
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN set -eux; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/*; \
    apt-get update -o Acquire::Retries=5; \
    apt-get install -y --no-install-recommends \
        libicu-dev \
        libpq-dev \
        libzip-dev \
        zip \
        unzip \
        git \
        libxml2-dev \
        libonig-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev; \
    docker-php-ext-install intl pdo pdo_mysql pdo_pgsql zip xml opcache gd; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Create public directory before composer install (needed for assets:install)
RUN mkdir -p /var/www/html/public

# Create .env file for composer install (excluded from .dockerignore)
RUN echo "APP_ENV=prod" > /var/www/html/.env && \
    echo "APP_SECRET=NotASecretJustForBuild" >> /var/www/html/.env && \
    echo "APP_DEBUG=0" >> /var/www/html/.env

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions for Symfony
RUN mkdir -p /var/www/html/var /var/www/html/vendor \
    && chown -R www-data:www-data /var/www/html/var /var/www/html/vendor /var/www/html/public

CMD ["php-fpm"]
