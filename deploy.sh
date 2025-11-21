#!/usr/bin/env bash
set -euo pipefail

APP_DIR="/var/www/nexo-invest"

echo ">> Deploying latest changes to ${APP_DIR}"
cd "${APP_DIR}"

echo ">> Pulling from origin/main (rebase)..."
git fetch origin
git pull --rebase origin main

echo ">> Installing JS dependencies and building assets..."
npm install --omit=dev
npm run build

echo ">> Clearing Laravel caches..."
php artisan optimize:clear

if php artisan migrate:status >/dev/null 2>&1; then
    echo ">> Running database migrations..."
    php artisan migrate --force
fi

echo "Deployment completed successfully."
