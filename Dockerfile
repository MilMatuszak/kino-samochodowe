FROM php:8.2-cli

# Zależności systemowe i rozszerzenia PHP wymagane przez Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer (kopiowany z oficjalnego obrazu)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Kopiowanie kodu aplikacji do obrazu
COPY . .

# Instalacja zależności PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 8000

# Serwer deweloperski Laravel nasłuchujący na wszystkich interfejsach
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000

