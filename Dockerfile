FROM php:7.3-apache
LABEL org.opencontainers.image.authors="samuel.dunesme@ens-lyon.fr"

RUN echo "[1] Install dependencies" \ 
    && apt-get update -qq \
    && apt-get install -y -qq libzip-dev zlib1g-dev \
        libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
        libpq-dev nodejs npm \
    && docker-php-ext-install bcmath zip gd pgsql pdo_pgsql
    
RUN echo "[2] Copy chrono-rhone files" \ 
    && mkdir /var/www/chrono-rhone
ADD . /var/www/chrono-rhone/

RUN echo "[3] Install php dependencies with composer" \ 
    && cd /var/www/chrono-rhone \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --quiet\
    && php -r "unlink('composer-setup.php');" \
    && ./composer.phar update \
    && ./composer.phar install

RUN echo "[4] Install application" \ 
    && cd /var/www/chrono-rhone \
    && php artisan config:cache \
    && php artisan storage:link \
    && chown www-data:www-data -R * \
    && npm install \
    && npm run prod

RUN echo "[5] Create and configure Apache VirtualHost" \ 
    && cd /etc/apache2/sites-available \
    && mv /var/www/chrono-rhone/apache-vhost.example.conf ./chrono-rhone.conf \
    && a2enmod rewrite \
    && a2ensite chrono-rhone.conf

# Clean image
RUN echo "[6] Clean image" \ 
    && apt-get autoremove -y -qq nodejs npm \
    && apt-get clean
