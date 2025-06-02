#!/bin/bash
composer install

chmod -R 775 /var/www/br/storage /var/www/br/bootstrap
chown -R www-data:www-data /var/www/br/storage /var/www/br/bootstrap

until nc -z db 3306; do
  echo "$(date) ⏳ Ожидаем запуска MySQL..."
  sleep 5
done

echo "✅ MySQL готов!"

php artisan key:generate

php artisan optimize:clear

php artisan optimize

php artisan migrate:fresh --seed

exec "$@"
