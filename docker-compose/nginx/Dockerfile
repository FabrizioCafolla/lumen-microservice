ARG TAG

FROM nginx:$TAG

LABEL maintainer="Fabrizio Cafolla <info@fabriziocafolla.com>"

# ADD data in image when build
ADD ./docker-compose/nginx/vhosts.conf /etc/nginx/conf.d/default.conf

# Set working directory as
WORKDIR /var/www
