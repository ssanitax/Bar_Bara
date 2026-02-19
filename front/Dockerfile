FROM php:8.2-apache

# Copiar todo el proyecto
COPY . /var/www/html/

# Cambiar el DocumentRoot a /front
RUN sed -i 's!/var/www/html!/var/www/html/front!g' /etc/apache2/sites-available/000-default.conf

# Permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

