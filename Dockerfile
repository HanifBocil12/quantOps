FROM tangramor/nginx-php8-fpm:php8.3.13_node22.11.0

COPY . /var/www/html

ENV WEBROOT="/var/www/html/public"
ENV CREATE_LARAVEL_STORAGE="1"

RUN apk add --no-cache --virtual .build-deps gcc g++ libc-dev make \
    && cd /var/www/html \
    && npm install \
    && composer install --no-dev --optimize-autoloader \
    && npm run build \
    && apk del .build-deps \
    && php artisan config:cache \
    && php artisan route:cache \
    && chown -Rf nginx.nginx /var/www/html