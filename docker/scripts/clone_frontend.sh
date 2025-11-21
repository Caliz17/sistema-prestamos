#!/bin/bash

cd /var/www/frontend

echo "Instalando Composer..."
composer install --no-interaction

# Crear .env si no existe
if [ ! -f ".env" ]; then
    cp .env.example .env
fi

echo "Aplicando configuración del entorno..."

set_env() {
    VAR="$1"
    VAL="$2"

    if grep -q "^$VAR=" .env; then
        sed -i "s|^$VAR=.*|$VAR=$VAL|" .env
    else
        echo "$VAR=$VAL" >> .env
    fi
}

# VARIABLES IMPORTANTES
set_env "APP_URL" "http://localhost:8001"
set_env "DB_CONNECTION" "mysql"
set_env "DB_HOST" "mysql"
set_env "DB_PORT" "3306"
set_env "DB_DATABASE" "prestamos_db"
set_env "DB_USERNAME" "root"
set_env "DB_PASSWORD" "root"

# AQUI PUEDES CAMBIAR EL HOST SEGÚN TU docker-compose.yml
set_env "API_URL" "http://prestamos-backend:8000/api"

# SESIONES
set_env "SESSION_DRIVER" "file"
set_env "SESSION_DOMAIN" "localhost"
set_env "SESSION_SECURE_COOKIE" "false"
set_env "SESSION_SAME_SITE" "lax"

echo "Generando APP_KEY..."
php artisan key:generate --force || true

echo "Esperando MySQL..."
until nc -z mysql 3306; do
  echo "Esperando MySQL..."
  sleep 2
done

echo "Iniciando servidor Laravel..."
php artisan serve --host=0.0.0.0 --port=8001 &

echo "Instalando NPM..."
npm install

echo "Iniciando Vite..."
npm run dev -- --host=0.0.0.0 --port=5173
