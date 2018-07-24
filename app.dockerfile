FROM php:7.2.2-fpm

RUN apt-get update  \
    && docker-php-ext-install pdo_mysql