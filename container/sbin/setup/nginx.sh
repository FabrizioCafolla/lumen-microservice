#!/bin/bash

source /usr/local/sbin/base.sh

main(){
	local HTTPS_CONF=/etc/nginx/sites-available/https
	local HTTP_CONF=/etc/nginx/sites-available/http

	if [ ! -f $HTTPS_CONF ]  || [ ! -f $HTTP_CONF ] ; then
	  exit 1
	fi

	#PID dir
 	mkdir -p /run/nginx

	local SERVER_NAME="${DOMAIN} www.${DOMAIN}"
	sed -i "s/%SERVERNAME%/${SERVER_NAME}/g" $HTTP_CONF
	sed -i "s/%SERVERNAME%/${SERVER_NAME}/g" $HTTPS_CONF
	sed -i "s/%WORKDIRPATH%/${WORKDIRPATH//\//\\\/}/g" $HTTPS_CONF
	sed -i "s/%APPNAME%/${APPNAME}/g" $HTTPS_CONF

	if [ ! -d /etc/nginx/sites-enabled ] ; then
	  mkdir -p /etc/nginx/sites-enabled
	fi	
	if [ -L /etc/nginx/sites-enabled/default ] ; then
	  rm /etc/nginx/sites-enabled/default
	fi
	ln -s $HTTP_CONF /etc/nginx/sites-enabled/http.conf
	ln -s $HTTPS_CONF /etc/nginx/sites-enabled/https.conf

	chown -R $WORKDIR_USER:$WORKDIR_GROUP /var/lib/nginx
}

main $@
