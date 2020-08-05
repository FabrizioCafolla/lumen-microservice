#!/bin/bash

source /usr/local/sbin/base.sh

main(){
	php-fpm --nodaemonize

}

main $@
