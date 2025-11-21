#!/bin/bash

FRONT_DIR="/var/www/frontend"
REPO_URL="https://github.com/Caliz17/prestamos-frontend.git"   # Cambia si es otro repo

############################################
# 1. CLONAR FRONTEND SI NO EXISTE
############################################
if [ ! -d "$FRONT_DIR/.git" ]; then
    echo "📦 Clonando frontend desde $REPO_URL ..."
    rm -rf $FRONT_DIR/*
    git clone $REPO_URL $FRONT_DIR
else
    echo "✔ Repositorio frontend ya existe, no se clona."
fi

cd $FRONT_DIR

############################################
# 2. CREAR .env SI NO EXISTE
############################################
if [ ! -f ".env" ]; then
    echo "📝 Creando .env desde .env.example ..."
    cp .env.example .env
fi

############################################
# 3. FUNCIÓN PARA ESTABLECER VARIABLES .env
############################################
set_env() {
    VAR="$1"
    VAL="$2"
    if grep -q "^$VAR=" .env; then
        sed -i "s|^$VAR=.*|$VAR=$VAL|" .env
    else
        echo "$VAR=$VAL" >> .env
    fi
}

############################################
# 4. CONFIGURACIÓN DOCKER EN .env
############################################
echo "⚙️ Configurando variables de entorno para Docker..."

# APP
set_env "APP_URL" "http://localhost:8001"

# BASE DE DATOS PARA EL FRONTEND
set_env "DB_CONNECTION" "mysql"
set_env "DB_HOST" "mysql"
set_env "DB_PORT" "3306"
set_env "DB_DATABASE" "prestamos_db"
set_env "DB_USERNAME" "root"
set_env "DB_PASSWORD" "root"

# API backend
set_env "API_URL" "http://prestamos-backend:8000/api"

# SESSION
set_env "SESSION_DRIVER" "file"
set_env "SESSION_DOMAIN" "localhost"
set_env "SESSION_SECURE_COOKIE" "false"
set_env "SESSION_SAME_SITE" "lax"

############################################
# 5. COMPOSER INSTALL
############################################
echo "📦 Instalando Composer..."
composer install --no-interaction

############################################
# 6. GENERAR APP_KEY
############################################
echo "🔑 Generando APP_KEY..."
php artisan key:generate --force || true

############################################
# 7. ESPERAR MYSQL
############################################
echo "⌛ Esperando MySQL..."
until nc -z -v -w5 mysql 3306; do
  echo "   ↳ MySQL no responde, reintentando..."
  sleep 2
done

############################################
# 8. EJECUTAR MIGRACIONES DEL FRONTEND
############################################
echo "🗃 Ejecutando migraciones del frontend..."
php artisan migrate --force || true

############################################
# 9. INICIAR SERVIDOR LARAVEL
############################################
echo "🚀 Iniciando servidor Laravel (frontend)..."
php artisan serve --host=0.0.0.0 --port=8001 &

############################################
# 10. NPM + VITE
############################################
echo "📦 Instalando dependencias de NPM..."
npm install

echo "🚀 Iniciando Vite..."
npm run dev -- --host=0.0.0.0 --port=5173

############################################
echo "🎉 Frontend listo y ejecutándose en Docker"
############################################
