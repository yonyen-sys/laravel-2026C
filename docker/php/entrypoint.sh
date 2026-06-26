#!/bin/sh
# Entrypoint for the Laravel app container
# Runs on container start: installs deps, generates key, sets permissions

set -e

# 1. Install PHP dependencies if vendor/ folder is missing
if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# 2. Ensure .env exists, then generate APP_KEY
if [ ! -f ".env" ]; then
    cp .env.example .env
fi
php artisan key:generate --force || true

# 3. Ensure storage & cache folders are writable by the web server
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 4. Pass control to the original command (php-fpm)
exec "$@"