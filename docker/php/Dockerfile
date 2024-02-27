FROM php:8.2-fpm-buster

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libonig-dev \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-install \
    zip mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/symfony
