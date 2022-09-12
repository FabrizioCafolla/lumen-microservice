FROM php:8.1-fpm-alpine AS build

LABEL mantainer="developer@fabriziocafolla.com"

ENV build_deps \
		autoconf \
        libzip-dev \
        curl-dev \
        oniguruma-dev \
        zlib-dev

ENV persistent_deps \
		build-base \
        git \
		unzip \
        curl \
        g++ \
        gcc \
        make \
        rsync \
        openssl \
        acl \
        openrc \
        bash \
        libzip \
        zlib \
        php8-common \
        php8-pdo \
        php8-opcache \
        php8-zip \
        php8-phar \
        php8-iconv \
        php8-cli \
        php8-curl \
        php8-openssl \
        php8-mbstring \
        php8-tokenizer \
        php8-fileinfo \
        php8-json \
        php8-xml \
        php8-xmlwriter \
        php8-simplexml \
        php8-dom \
        php8-pdo_mysql \
        php8-pdo_sqlite \
        php8-tokenizer \
        php8-pecl-redis

# Install build dependencies
RUN apk upgrade --update-cache --available && apk update && \
    apk add --virtual .build-dependencies $build_deps

# Install persistent dependencies
RUN apk add --update --virtual .persistent-dependencies $persistent_deps && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

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

ARG ENV
ENV ENV ${ENV}

ARG APPNAME
ENV APPNAME ${APPNAME}

ARG DOMAIN 
ENV DOMAIN ${DOMAIN}

ARG WORKDIR_USER="www-data"
ENV WORKDIR_USER ${WORKDIR_USER}

ARG WORKDIR_GROUP="www-data"
ENV WORKDIR_GROUP ${WORKDIR_GROUP}

ARG WORKDIRPATH="/var/www/application"
ENV WORKDIRPATH ${WORKDIRPATH}

RUN test -n "${ENV}" || (echo "[BUILD ARG] ENV not set" && false) && \
    test -n "${APPNAME}" || (echo "[BUILD ARG] APPNAME not set" && false) && \
    test -n "${DOMAIN}" || (echo "[BUILD ARG] DOMAIN not set" && false)

# Install nginx webserver
ARG NGINX_VERSION="1.22.0-r1"
ENV NGINX_VERSION ${NGINX_VERSION}
RUN apk add --update --no-cache nginx==$NGINX_VERSION

COPY ./container/etc/nginx /etc/nginx
COPY ./container/etc/php /usr/local/etc
COPY --chown=${WORKDIR_USER}:${WORKDIR_GROUP} ./container/sbin /usr/local/sbin

# Set working directory as
WORKDIR ${WORKDIRPATH}

RUN chmod 755 -R /usr/local/sbin \
    && chown -R ${WORKDIR_USER}:${WORKDIR_GROUP} /etc/nginx \
    && chown -R ${WORKDIR_USER}:${WORKDIR_GROUP} /var/log \
    && chown -R ${WORKDIR_USER}:${WORKDIR_GROUP} /var/lib/nginx 

USER ${WORKDIR_USER}

ENTRYPOINT ["/usr/local/sbin/entrypoint"]

# Dev
FROM build as develop
USER root

# Build app
FROM build as app

USER root

COPY --chown=${WORKDIR_USER}:${WORKDIR_GROUP} ./source ${WORKDIRPATH}

RUN composer install --no-dev --no-scripts --no-suggest --no-interaction --prefer-dist --optimize-autoloader \
    && composer dump-autoload --no-dev --optimize --classmap-authoritative \
    && chown -R ${WORKDIR_USER}:${WORKDIR_GROUP} ${WORKDIRPATH}/* \
    && chown -R ${WORKDIR_USER}:${WORKDIR_GROUP} ${WORKDIRPATH}/.* \
    && find ${WORKDIRPATH} -type f -exec chmod 644 {} \; \
    && find ${WORKDIRPATH} -type d -exec chmod 775 {} \;

# Production
FROM build as production
COPY --from=app ${WORKDIRPATH} ${WORKDIRPATH}

# Qa
FROM build as qa
COPY --from=app ${WORKDIRPATH} ${WORKDIRPATH}