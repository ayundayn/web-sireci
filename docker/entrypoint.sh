#!/usr/bin/env sh
set -e

if [ ! -f .env ]; then
    cp .env.docker .env
fi

set_env() {
    key="$1"
    value="$2"

    if [ -z "$value" ]; then
        return
    fi

    escaped_value=$(printf '%s' "$value" | sed 's/[\/&]/\\&/g')

    if grep -q "^${key}=" .env; then
        sed -i "s/^${key}=.*/${key}=${escaped_value}/" .env
    else
        printf '\n%s=%s\n' "$key" "$value" >> .env
    fi
}

set_env APP_URL "$APP_URL"
set_env DB_CONNECTION "$DB_CONNECTION"
set_env DB_HOST "$DB_HOST"
set_env DB_PORT "$DB_PORT"
set_env DB_DATABASE "$DB_DATABASE"
set_env DB_USERNAME "$DB_USERNAME"
set_env DB_PASSWORD "$DB_PASSWORD"
set_env SESSION_DRIVER "$SESSION_DRIVER"
set_env QUEUE_CONNECTION "$QUEUE_CONNECTION"
set_env CACHE_STORE "$CACHE_STORE"
set_env ML_SERVICE_URL "$ML_SERVICE_URL"
set_env GOOGLE_CLIENT_ID "$GOOGLE_CLIENT_ID"
set_env GOOGLE_CLIENT_SECRET "$GOOGLE_CLIENT_SECRET"
set_env GOOGLE_REDIRECT_URI "$GOOGLE_REDIRECT_URI"

composer install --no-interaction --prefer-dist
npm install

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

php artisan storage:link >/dev/null 2>&1 || true
php artisan config:clear

exec "$@"
