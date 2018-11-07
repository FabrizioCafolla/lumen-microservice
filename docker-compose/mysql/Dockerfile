ARG TAG

FROM mysql:$TAG

LABEL maintainer="Fabrizio Cafolla <info@fabriziocafolla.com>"

# ADD data in image when build
ADD ./docker-compose/image/mysql/data/ /var/lib/mysql
