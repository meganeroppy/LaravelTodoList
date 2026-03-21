#!/bin/sh

# Replace PORT in nginx config
envsubst '${PORT}' < /etc/nginx/sites-available/default.template > /etc/nginx/sites-available/default

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force

# Start PHP-FPM in the background
php-fpm -D

# Start Nginx in the foreground
nginx -g 'daemon off;'
