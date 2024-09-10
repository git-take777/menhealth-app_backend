#!/bin/bash
set -e

if [ ! -f "/var/www/backend/artisan" ]; then
    cd /var/www/backend
    composer create-project --prefer-dist laravel/laravel:^10.0 .
    composer install
    chown -R www-data:www-data /var/www/backend
    chmod -R 775 ./var/www/backend/storage /var/www/backend/bootstrap/cache
fi

exec "$@"