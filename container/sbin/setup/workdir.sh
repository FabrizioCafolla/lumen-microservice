#!/bin/bash

source /usr/local/sbin/base.sh

main(){
  mkdir -p /var/www/

  chown -R root:$WORKDIR_GROUP /var/www

  chmod -R 754 /var/www

  setfacl -R -m g:$WORKDIR_GROUP:rwX /var/www
  setfacl -R -d -m g:$WORKDIR_GROUP:rwX /var/www
}

main $@
