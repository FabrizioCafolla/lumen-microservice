ARG TAG=1.0

FROM fabriziocaf/lumen:$TAG

COPY ./source /var/www/

USER root

RUN cp .env.example .env \
    && set -xe \
    && composer install --no-dev --no-scripts --no-suggest --no-interaction --prefer-dist --optimize-autoloader \
    && composer dump-autoload --no-dev --optimize --classmap-authoritative

USER www-data