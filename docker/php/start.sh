#!/bin/bash

cd /var/www

composer install

cp -n .env.example .env

php artisan key:generate

php artisan migrate

php-fpm
