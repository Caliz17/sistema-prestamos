#!/bin/bash

# Si no existe la carpeta, clonar
if [ ! -d "/var/www/frontend" ]; then
    echo "Clonando frontend..."
    git clone https://github.com/Caliz17/prestamos-frontend.git /var/www/frontend
fi

cd /var/www/frontend

echo "Instalando dependencias NPM..."
npm install

echo "Levantando Vite (Tailwind + HMR)..."
npm run dev -- --host 0.0.0.0 --port=8001
