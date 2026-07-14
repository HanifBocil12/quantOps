FROM --platform=linux/amd64 tangramor/nginx-php8-fpm:php8.3.13_node22.11.0

COPY . /var/www/html

ENV WEBROOT="/var/www/html/public"
ENV CREATE_LARAVEL_STORAGE="1"

RUN cd /var/www/html \
    && composer install --no-dev --optimize-autoloader \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && chown -Rf nginx.nginx /var/www/html