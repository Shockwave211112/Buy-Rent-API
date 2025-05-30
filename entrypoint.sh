#!/bin/bash
composer install

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
