#!/bin/bash

cd /var/www/frontend

echo "Instalando Composer..."
composer install --no-interaction

# Crear .env si no existe
if [ ! -f ".env" ]; then
    cp .env.example .env
fi

echo "Configurando .env para Docker..."

sed -i "s|^APP_URL=.*|APP_URL=http://localhost:8001/api|" .env
sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=mysql|" .env
echo "API_URL=http://backend:8000/api" >> .env
grep -q "^API_URL=" .env || echo "API_URL=http://backend:8000/api" >> .env
sed -i "s|^DB_HOST=.*|DB_HOST=mysql|" .env
sed -i "s|^DB_PORT=.*|DB_PORT=3306|" .env
sed -i "s|^DB_DATABASE=.*|DB_DATABASE=prestamos_db|" .env
sed -i "s|^DB_USERNAME=.*|DB_USERNAME=root|" .env
sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=root|" .env
sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=file|" .env

php artisan key:generate --force || true

echo "Esperando MySQL..."
until nc -z -v -w5 mysql 3306; do
  sleep 2
done

echo "Iniciando servidor Laravel..."
php artisan serve --host=0.0.0.0 --port=8001 &

echo "Instalando NPM..."
npm install

echo "Iniciando Vite..."
npm run dev -- --host=0.0.0.0 --port=5173
