#!/bin/bash
set -e

# Asegurar directorios de almacenamiento y permisos totales
mkdir -p /var/www/html/storage/framework/{sessions,views,cache} /var/www/html/storage/logs
touch /var/www/html/storage/logs/laravel.log || true
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Generar clave si no existe
if [ -z "$APP_KEY" ]; then
    echo "Generando APP_KEY..."
    php artisan key:generate --force || true
fi

# Migraciones si hay conexión configurada
if [ -n "$DB_HOST" ]; then
    echo "Ejecutando migraciones de base de datos..."
    php artisan migrate --force || true
fi

# Optimización y caché
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

echo "Iniciando MunchHub en Render..."
exec "$@"
