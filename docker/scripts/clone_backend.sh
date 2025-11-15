#!/bin/bash

# Si no existe la carpeta, clonar
if [ ! -d "/var/www/backend" ]; then
    echo "Clonando backend..."
    git clone https://github.com/Caliz17/prestamos-api.git /var/www/backend
fi

cd /var/www/backend

echo "Instalando dependencias de Composer..."
composer install

# Crear .env si no existe
if [ ! -f ".env" ]; then
    echo "Copiando archivo .env..."
    cp .env.example .env
fi

echo "Generando APP_KEY..."
php artisan key:generate || true

# Esperar que MySQL esté listo
echo "Esperando a MySQL..."
until nc -z -v -w30 mysql 3306
do
  echo "Esperando base de datos..."
  sleep 5
done

echo "Ejecutando migraciones..."
php artisan migrate --force || true

echo "Levantando servidor Laravel..."
php artisan serve --host=0.0.0.0 --port=8000
