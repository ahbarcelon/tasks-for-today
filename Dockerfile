FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libicu-dev libonig-dev \
    && docker-php-ext-install intl mbstring mysqli \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . .
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/railway-entrypoint.sh /usr/local/bin/railway-entrypoint

RUN sed -i 's/\r$//' /usr/local/bin/railway-entrypoint \
    && chmod +x /usr/local/bin/railway-entrypoint \
    && chown -R www-data:www-data /var/www/html/writable

ENV CI_ENVIRONMENT=production
EXPOSE 80

ENTRYPOINT ["railway-entrypoint"]
CMD ["apache2-foreground"]
