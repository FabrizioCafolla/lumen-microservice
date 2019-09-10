FROM php:7.3.8-fpm-alpine

LABEL mantainer="developer@fabriziocafolla.com"
LABEL description="Production container"

ENV build_deps \
		autoconf \
		libzip-dev \
        libxslt-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        freetype-dev

ENV persistent_deps \
		build-base \
		libxslt \
		libjpeg-turbo \
		libpng \
		freetype \
		unzip \
		php-xml \
		php-zip \
		git \
        mysql-client

# Set working directory as
WORKDIR /var/www

# Copy application file in image
COPY ./ /var/www

# Add permission to workdir
RUN chown -R www-data:www-data ./* \
    && chown -R www-data:www-data ./.* \
    && find . -type f -exec chmod 644 {} \; \
    && find . -type d -exec chmod 775 {} \;

# Install build dependencies
RUN apk upgrade && apk update && \
    apk add --no-cache --virtual .build-dependencies $build_deps

# Install persistent dependencies
RUN apk add --update --no-cache --virtual .persistent-dependencies $persistent_deps && \
    printf "\n" | pecl install -o -f redis && \
    rm -rf /tmp/pear && \
    docker-php-ext-enable redis

# Install docker ext and remove build deps
RUN apk update && \
    docker-php-ext-configure gd \
        --with-gd \
        --with-freetype-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ && \
        NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
        docker-php-ext-install -j${NPROC} gd && \
    docker-php-ext-install mysqli pdo pdo_mysql \
        xsl \
        mbstring \
        zip \
        opcache \
        pcntl && \
        apk del .build-dependencies

# composer install and init dir
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev && \
    rm -rf /usr/local/bin/composer* && \
    cp .env.example .env

EXPOSE 9000