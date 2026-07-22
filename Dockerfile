# Stage 1: build frontend assets using a glibc-based Node image
# (avoids rolldown's musl native binding issue that occurs on Alpine)
FROM node:22-bookworm-slim AS assets

WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm install

COPY . .
RUN npm run build

# Stage 2: final runtime image
FROM tangramor/nginx-php8-fpm:php8.3.13_node22.11.0

COPY . /var/www/html

# bring in the compiled assets from the build stage
COPY --from=assets /app/public/build /var/www/html/public/build

ENV WEBROOT="/var/www/html/public"
ENV CREATE_LARAVEL_STORAGE="1"

RUN cd /var/www/html \
    && composer install --no-dev --optimize-autoloader \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && chown -Rf nginx.nginx /var/www/html