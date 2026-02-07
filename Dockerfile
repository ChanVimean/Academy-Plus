# 1. Use PHP 8.4 Apache as the base (matches your composer.lock requirements)
FROM php:8.4-apache

# 2. Install system dependencies for Laravel and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring gd bcmath zip intl

# 3. Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# 4. Set Composer Memory Limit
ENV COMPOSER_MEMORY_LIMIT=-1

# 5. Copy project files to the container
COPY . /var/www/html
WORKDIR /var/www/html

# 6. Install Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Run Composer Install (One single command)
RUN composer install --ignore-platform-reqs --no-dev --optimize-autoloader --no-interaction --no-scripts

# 8. Set permissions for Laravel storage and cache
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Point Apache to Laravel's /public folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# 10. Expose port 80
EXPOSE 80

# 11. Start Apache in the foreground
CMD ["apache2-foreground"]
