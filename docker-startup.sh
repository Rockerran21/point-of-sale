#!/bin/sh
set -e
until mysql -h "$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" --connect-timeout=5 --skip-ssl -e "SELECT 1" >/dev/null 2>&1; do
  sleep 2
done
php artisan key:generate
php artisan migrate --seed --force
php artisan storage:link
php -S 0.0.0.0:8000 -t public

