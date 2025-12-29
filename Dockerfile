# Usar una imagen de PHP con Apache
FROM php:8.2-apache

# Instalar extensiones de PHP requeridas
RUN apt-get update && apt-get install -y libzip-dev libwebp-dev zlib1g-dev libxml2-dev libpng-dev libjpeg-dev libfreetype6-dev && \
    rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo pdo_mysql gd bcmath xml zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

COPY . /var/www/html
RUN mv /var/www/html/.env.dev /var/www/html/.env

# Otorgar permisos adecuados a los directorios de Laravel
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html/storage && chmod -R 755 /var/www/html/bootstrap/cache

# Exponer el puerto 80
EXPOSE 80