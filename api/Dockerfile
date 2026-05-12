# Use the official PHP 8.2 FPM image with extensions
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
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
    docker-php-ext-install -j$(nproc) intl pdo pdo_mysql pdo_pgsql zip xml dom opcache gd; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Create public directory before composer install (needed for assets:install)
RUN mkdir -p /var/www/html/public

# Install dependencies without post-install scripts (which require runtime setup)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Set permissions for Symfony
RUN mkdir -p /var/www/html/var /var/www/html/vendor \
    && chown -R www-data:www-data /var/www/html/var /var/www/html/vendor /var/www/html/public

CMD ["php-fpm"]
