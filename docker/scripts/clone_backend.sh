#!/bin/bash

if [ ! -d "/var/www/backend/.git" ]; then
    echo "Clonando backend..."
    rm -rf /var/www/backend/*
    git clone https://github.com/Caliz17/prestamos-api.git /var/www/backend
fi

cd /var/www/backend

echo "Composer install..."
composer install

if [ ! -f ".env" ]; then
    echo "Copiando .env..."
    cp .env.example .env
fi

echo "Configurando .env para Docker..."
sed -i "s|DB_HOST=.*|DB_HOST=mysql|" .env
sed -i "s|DB_DATABASE=.*|DB_DATABASE=prestamos_db|" .env
sed -i "s|DB_USERNAME=.*|DB_USERNAME=root|" .env
sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=root|" .env
sed -i "s|API_URL=.*|API_URL=http://backend:8000/api|" .env

echo "APP_KEY..."
php artisan key:generate

echo "Esperando MySQL..."
until nc -z mysql 3306; do
  sleep 2
done

echo "Migrando..."
php artisan migrate --force

echo "Iniciando backend..."
php artisan serve --host=0.0.0.0 --port=8000
