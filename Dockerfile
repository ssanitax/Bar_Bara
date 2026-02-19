FROM php:8.2-apache

# Copiar todo el proyecto
COPY . /var/www/html/

# Cambiar el DocumentRoot a /front
RUN sed -i 's!/var/www/html!/var/www/html/front!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

