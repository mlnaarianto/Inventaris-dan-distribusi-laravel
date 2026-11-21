#!/bin/sh
set -e

cd /var/www

# Pastikan folder yang dibutuhkan Laravel ada dan bisa ditulis
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R ug+rwX storage bootstrap/cache 2>/dev/null || true

exec "$@"