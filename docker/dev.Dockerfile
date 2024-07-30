FROM php:8.3.9-alpine AS build

# Instalar dependencias necesarias
RUN apk add --no-cache \
    postgresql-dev \
    libzip-dev \
    zip \
    unzip \
    icu-dev

# Instalar y habilitar extensiones de PHP
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip intl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar archivos de composición
COPY composer.json composer.lock ./

# Instalar dependencias
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-scripts --no-autoloader --no-dev

# Copiar el resto de los archivos
COPY app/ app/
COPY public/ public/
COPY spark .
COPY preload.php .
COPY builds/ builds/
COPY writable/ writable/

# Generar el autoloader optimizado
RUN COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize --no-dev

FROM php:8.3.9-alpine AS final

# Copiar extensiones y configuraciones de PHP
COPY --from=build /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=build /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Instalar dependencias de tiempo de ejecución
RUN apk add --no-cache \
    postgresql-libs \
    libzip \
    icu

WORKDIR /var/www/html

# Copiar archivos de la aplicación
COPY --from=build /app /var/www/html

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/writable

EXPOSE 8080

CMD ["php", "spark", "serve", "--host", "0.0.0.0", "--port", "8080"]