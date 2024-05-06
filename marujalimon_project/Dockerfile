# Utiliza la imagen oficial de PHP con Zend OPcache
FROM php:8.3.4

# Instala las dependencias necesarias
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        git \
        && docker-php-ext-install zip pdo_mysql # Añadimos pdo_mysql aquí para instalar el controlador PDO de MySQL

# Instala Composer
COPY --from=composer:2.7.2 /usr/bin/composer /usr/bin/composer

# Instala Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_21.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm@10.5.0

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de tu proyecto
COPY . .

# Ejecuta composer install para instalar las dependencias de PHP
RUN composer install --no-interaction

# Limpia la cache de Composer
RUN composer clear-cache

# Comando predeterminado para iniciar el servidor web
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
