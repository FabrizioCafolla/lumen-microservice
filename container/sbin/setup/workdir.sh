#!/bin/bash

source /usr/local/sbin/base.sh

main(){
  mkdir -p $WORKDIRPATH

  chown -R root:$WORKDIR_GROUP $WORKDIRPATH

  chmod -R 754 $WORKDIRPATH

  setfacl -R -m g:$WORKDIR_GROUP:rwX $WORKDIRPATH
  setfacl -R -d -m g:$WORKDIR_GROUP:rwX $WORKDIRPATH
}

main $@
