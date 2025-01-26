FROM php:8.2-apache

# Habilitar módulos necesarios
RUN a2enmod rewrite

# Instalar dependencias necesarias y PHP extensions en un solo comando RUN
RUN apt-get update && apt-get install -y \
    unzip \
    zlib1g-dev \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql gd xml simplexml iconv zip dom \
    && docker-php-ext-enable dom \
    && export CFLAGS="-I/usr/src/php" \
    && docker-php-ext-install xmlreader \
    && docker-php-ext-enable xmlreader

# Instalar Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
&& apt-get install -y nodejs

# Verificar la instalación de Node.js y npm
RUN node -v && npm -v

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar la configuración de Apache
COPY ./Docker/web-server-apache-php/000-default.conf /etc/apache2/sites-available/000-default.conf

# Habilitar el archivo de configuración de Apache
RUN a2ensite 000-default.conf

COPY ./Docker/web-server-apache-php/script-permissions.sh /usr/local/bin/script-permissions.sh
RUN chmod +x /usr/local/bin/script-permissions.sh

# Cambiar el entrypoint para ejecutar el script
ENTRYPOINT ["/usr/local/bin/script-permissions.sh"]

# Exponer el puerto 80
EXPOSE 80