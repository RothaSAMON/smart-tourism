#!/usr/bin/env bash

set -euo pipefail

CONTAINER="smart-tourism-laravel.test-1"

echo "🚀 Starting deployment..."

echo "📥 Pulling latest code..."
git pull --ff-only

echo "📦 Installing Composer dependencies..."
docker exec -i "$CONTAINER" composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --classmap-authoritative \
    --no-interaction \
    --no-progress

echo "🗄️ Running database migrations..."
docker exec -i "$CONTAINER" php artisan migrate --force

echo "🧹 Clearing Laravel cache..."
docker exec -i "$CONTAINER" php artisan optimize:clear

echo "♻️ Restarting queue workers..."
docker exec -i "$CONTAINER" php artisan queue:restart

echo "✅ Deployment completed successfully!"
