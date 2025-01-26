#!/bin/bash

# Configurar permisos de Laravel
chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Ejecutar el comando de Apache en segundo plano
apache2-foreground
