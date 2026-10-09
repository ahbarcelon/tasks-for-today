#!/bin/sh
set -eu

if [ "${PORT:-80}" != "80" ]; then
    sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
    sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
fi

attempt=1
until php -r '
    mysqli_report(MYSQLI_REPORT_OFF);
    $db = @new mysqli(
        (string) getenv("MYSQLHOST"),
        (string) getenv("MYSQLUSER"),
        (string) getenv("MYSQLPASSWORD"),
        (string) getenv("MYSQLDATABASE"),
        (int) (getenv("MYSQLPORT") ?: 3306)
    );
    if ($db->connect_errno !== 0) {
        fwrite(STDERR, "Database connection failed: {$db->connect_error}\n");
        exit(1);
    }
'; do
    if [ "$attempt" -ge 10 ]; then
        echo "Database did not become ready after ${attempt} attempts." >&2
        exit 1
    fi

    echo "Database is not ready; retrying in 3 seconds (${attempt}/10)." >&2
    attempt=$((attempt + 1))
    sleep 3
done

echo "Database connection is ready; preparing the schema."
php docker/bootstrap.php
echo "Database schema is ready; starting Apache on port ${PORT:-80}."

exec apache2-foreground
