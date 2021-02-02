#!/bin/bash

set -eE -o functrace

failure() {
  local lineno=$1
  local msg=$2
  echo "Failed at $lineno: $msg"
}
trap 'failure ${LINENO} "$BASH_COMMAND"' ERR

set -o pipefail
set -o nounset

if [ -z ${ENV:-} ] || [ -z ${APPNAME:-} ] || [ -z ${DOMAIN:-} ] ; then
  echo "Corrupted build"
  exit 1
fi

if [ -z ${WORKDIR_USER:-} ] ; then
  WORKDIR_USER="www-data"
fi

if [ -z ${WORKDIR_GROUP:-} ] ; then
  WORKDIR_GROUP="www-data"
fi

if [ -z ${WORKDIRPATH:-} ] ; then
  WORKDIRPATH="/var/www"
fi

SCRIPTS_BASEPATH=/usr/local/sbin
SERVICEPATH="${SCRIPTS_BASEPATH}/services"
SETUPPATH="${SCRIPTS_BASEPATH}/setup"

WWW_DOMAIN="www.${DOMAIN}"
