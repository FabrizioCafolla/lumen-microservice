#!/bin/bash

source /usr/local/sbin/base.sh

main(){
	openssl req -x509 -nodes -new -sha256 -days 1024 -newkey rsa:2048 -keyout ${APPNAME}.key -out ${APPNAME}.pem -subj "/C=US/CN=${DOMAIN}"
	openssl x509 -outform pem -in ${APPNAME}.pem -out ${APPNAME}.crt
	
	local cert_path="/etc/cert/${APPNAME}"

	mkdir -p $cert_path

	chmod 750 $cert_path
	chown root:root $cert_path
	setfacl -R -m g:www-data:r-x $cert_path

	mv ${APPNAME}.key $cert_path/private.pem
	mv ${APPNAME}.crt $cert_path/fullchain.pem
	rm -f ${APPNAME}.pem
}

main $@
