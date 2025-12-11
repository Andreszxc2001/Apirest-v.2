#!/bin/bash
set -e

# Default PORT if not provided
: "${PORT:=8080}"

# Set a ServerName to silence warnings
echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf
a2enconf servername >/dev/null || true

# Update Apache listen port(s)
if [ -f /etc/apache2/ports.conf ]; then
  sed -ri "s/Listen [0-9]+/Listen ${PORT}/g" /etc/apache2/ports.conf || true
fi

# Update the default virtual host to match the port
if [ -f /etc/apache2/sites-available/000-default.conf ]; then
  sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/000-default.conf || true
fi

# Ensure www-data owns the app files
chown -R www-data:www-data /var/www/html || true

# Exec the upstream container entrypoint with apache in foreground
exec docker-php-entrypoint apache2-foreground
