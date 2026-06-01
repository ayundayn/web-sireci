#!/usr/bin/env sh
set -e

if [ ! -f .env ]; then
    cp .env.docker .env
fi

composer install --no-interaction --prefer-dist
npm install

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

php artisan storage:link >/dev/null 2>&1 || true
php artisan config:clear

exec "$@"
