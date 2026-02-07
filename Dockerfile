FROM php:8.3-apache

# 1. Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev git unzip libpng-dev libonig-dev libxml2-dev zip libzip-dev libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring gd bcmath zip intl

# 2. Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# 3. Set Composer Memory Limit (Crucial for Free Tiers)
ENV COMPOSER_MEMORY_LIMIT=-1

# 4. Copy project files
COPY . /var/www/html
WORKDIR /var/www/html

# 5. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 6. Set permissions (and create folders if they don't exist)
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 7. Fix Apache document root to Laravel's /public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# 8. Final Command
CMD ["apache2-foreground"]
