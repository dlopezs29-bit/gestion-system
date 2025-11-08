# Usa PHP 8.2 con Apache
FROM php:8.2-apache

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    libicu-dev \
    unzip \
    && docker-php-ext-install intl mysqli \
    && docker-php-ext-enable intl mysqli \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Habilita mod_rewrite (necesario para rutas amigables de CodeIgniter)
RUN a2enmod rewrite

# Copia todo el proyecto al contenedor
COPY . /var/www/html/

# Define el directorio de trabajo
WORKDIR /var/www/html

# Copia el archivo .env (Render a veces lo ignora si no lo agregas explícitamente)
# Esto asegura que el entorno de producción se use dentro del contenedor
COPY .env /var/www/html/.env

# Asegura los permisos correctos para las carpetas de escritura
RUN mkdir -p /var/www/html/writable/session /var/www/html/writable/cache \
    && chown -R www-data:www-data /var/www/html/writable /var/www/html/.env \
    && chmod -R 755 /var/www/html/writable

# Configuración de Apache para apuntar a la carpeta 'public'
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Exponer el puerto 80
EXPOSE 80

# Comando para ejecutar Apache
CMD ["apache2-foreground"]
