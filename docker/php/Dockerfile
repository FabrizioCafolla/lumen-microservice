#
# STAGE: composer
#
FROM composer:1.10.0 as vendor
 
# Copy composer files from project root into composer container's working dir
COPY ./source/composer.* /app/

RUN composer global require "hirak/prestissimo"

# Run composer to build dependencies in vendor folder
RUN set -xe \
 && composer install --no-dev --no-scripts --no-suggest --no-interaction --prefer-dist --optimize-autoloader
 
# Generated optimized autoload files containing all classes from vendor folder and project itself
RUN composer dump-autoload --no-dev --optimize --classmap-authoritative

#
# STAGE: production
#
FROM php:7.4.3-fpm-alpine

LABEL mantainer="developer@fabriziocafolla.com"
LABEL description="Production container"

ENV build_deps \
		autoconf \
        libzip-dev \
        curl-dev \
        oniguruma-dev 

ENV persistent_deps \
		build-base \
        git \
		unzip \
        curl \
        g++ \
        gcc \
        make \
        mysql-client \
        php-xml \
        php-zip \
        rsync

# Set working directory as
WORKDIR /var/www

# Copy application file in image
COPY ./source /var/www/

# Copy vendor folder from composer container into php container
COPY --from=vendor /app/vendor vendor

# Add permission to workdir
RUN cp .env.example .env \
    && chown -R www-data:www-data ./* \
    && chown -R www-data:www-data ./.* \
    && find . -type f -exec chmod 644 {} \; \
    && find . -type d -exec chmod 775 {} \; \
    && chmod -R 777 storage 

# Install build dependencies
RUN apk upgrade && apk update && \
    apk add --no-cache --virtual .build-dependencies $build_deps

# Install persistent dependencies
RUN apk add --update --no-cache --virtual .persistent-dependencies $persistent_deps 

# Install docker ext and remove build deps
RUN apk update \
    && docker-php-ext-configure zip \
    && docker-php-ext-install mysqli \
        pdo \
        pdo_mysql \
        bcmath \
        curl \
        pcntl \
        zip \
        exif \
    && apk del -f .build-dependencies

# Change current user to www
USER www-data

CMD ["php-fpm", "--nodaemonize"]