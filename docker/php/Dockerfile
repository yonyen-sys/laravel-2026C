# Use official PHP 8.2 image with FPM (required for nginx to talk to PHP)
FROM php:8.2-fpm

# Set working directory inside the container (must match docker-compose working_dir)
WORKDIR /var/www/html

# Install system dependencies + the PHP extensions Laravel needs (pdo_mysql is the critical one)
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer (PHP package manager)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the entrypoint script and make it executable
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose PHP-FPM port
EXPOSE 9000

# Run the entrypoint (handles composer install, key generation, perms)
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]