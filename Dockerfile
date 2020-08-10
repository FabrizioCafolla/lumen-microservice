FROM php:7.4.3-fpm-alpine AS build

LABEL mantainer="developer@fabriziocafolla.com"
LABEL description="Production container"

ARG ENV
ARG APPNAME
ARG DOMAIN 

RUN test -n "${ENV}" || (echo "[BUILD ARG] ENV not set" && false) && \
    test -n "${APPNAME}" || (echo "[BUILD ARG] APPNAME not set" && false) && \
    test -n "${DOMAIN}" || (echo "[BUILD ARG] DOMAIN not set" && false)

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
        rsync \
        nginx \
        openssl \
        acl \
        openrc \
        bash

# Set working directory as
WORKDIR /var/www

# Install build dependencies
RUN apk upgrade --update-cache --available && apk update && \
    apk add --no-cache --virtual .build-dependencies $build_deps

# Install persistent dependencies
RUN apk add --update --no-cache --virtual .persistent-dependencies $persistent_deps \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer\
    && composer global require "hirak/prestissimo" 

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

COPY ./container/etc/nginx /etc/nginx
COPY ./container/etc/php /usr/local/etc
COPY ./container/sbin /usr/local/sbin

ENV ENV ${ENV}
ENV APPNAME ${APPNAME}
ENV DOMAIN ${DOMAIN}
ENV WORKDIR_USER ${WORKDIR_USER}
ENV WORKDIR_GROUP ${WORKDIR_GROUP}
ENV WORKDIRPATH ${WORKDIRPATH}

RUN chmod 754 -R /usr/local/sbin \
    && setfacl -R -m g:www-data:rwx /usr/local/sbin \
    && /usr/local/sbin/setup/nginx.sh \ 
    && /usr/local/sbin/setup/workdir.sh \
    && /usr/local/sbin/setup/create_cert.sh 

USER www-data

ENTRYPOINT ["/usr/local/sbin/services/init.sh"]

#DEV
FROM build as dev

USER root

RUN apk update && apk upgrade && \
    apk add mysql-client 
    
#PROD
FROM build as pro

ARG DB_HOST
ARG DB_NAME
ARG DB_PASS 

RUN test -n "${DB_HOST}" || (echo "[BUILD ARG] DB_HOST not set" && false) && \
    test -n "${DB_NAME}" || (echo "[BUILD ARG] DB_NAME not set" && false) && \
    test -n "${DB_PASS}" || (echo "[BUILD ARG] DB_PASS not set" && false)

COPY --chown=www-data:www-data ./lumen /var/www/lumen

USER root

RUN cp .env.example .env \
    && set -xe \
    && composer install --no-dev --no-scripts --no-suggest --no-interaction --prefer-dist --optimize-autoloader \
    && composer dump-autoload --no-dev --optimize --classmap-authoritative

USER www-data

