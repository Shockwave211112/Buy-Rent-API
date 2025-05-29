#!/bin/bash
composer install

php artisan key:generate

php artisan optimize:clear

php artisan optimize

exec "$@"
