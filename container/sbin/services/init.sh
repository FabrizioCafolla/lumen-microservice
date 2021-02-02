#!/bin/bash

source /usr/local/sbin/base.sh

main(){
	# Add permission to workdir
	chown -R www-data:www-data ./* \
		&& chown -R www-data:www-data ./.* \
		&& find . -type f -exec chmod 644 {} \; \
		&& find . -type d -exec chmod 775 {} \; 

	nginx -c /etc/nginx/nginx.conf
	mkdir -p /run/php
	php-fpm
}

main $@
