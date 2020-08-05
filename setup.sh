#!/bin/bash

set -eE -o functrace

failure() {
  local lineno=$1
  local msg=$2
  echo "Failed at $lineno: $msg"
}
trap 'failure ${LINENO} "$BASH_COMMAND"' ERR

set -o pipefail

ENV_VALIDATOR=("dev" "sta" "pro")
FILE_ENV="./.env"
FILE_ENV_EXAMPLE="./example.env"

parser(){
    options=$(getopt -l "help,env:,appname:,domain:" -o "h e: a: d:" -a -- "$@")
    eval set -- "$options"

    while true
       do
        case $1 in
            -h|--help)
                showHelp
                ;;
            -e|--env)
                ENV=$2
                ;;
            -a|--appname)
                APPNAME=$2
                ;;
            -d|--domain)
                DOMAIN=$2
                ;;
            --)
                shift
                break;;
        esac
        shift
    done

    shift "$(($OPTIND -1))"

  if [ -z $ENV ] ; then
    read -p 'Env, digit one of dev,sta,pro: ' ENV
  fi
  [[ ${ENV_VALIDATOR[@]} =~ (^|[[:space:]])$ENV($|[[:space:]]) ]] || (echo "ENV not valid" && exit 1) 
  
  if [ -z $APPNAME ] ; then
    read -p 'App name: ' APPNAME
  fi
  [[ "$APPNAME" != "" ]] || (echo 'APPNAME not valid' && exit 1)

  if [ -z $DOMAIN ] ; then
    DOMAIN="$APPNAME.local"
  fi
}

update_env() {
  local _file=${1}
  local _key=${2}
  local _value=${3}
  echo "${_key}=${_value}" >> ${_file}
}

set_dev_env() {
  read -p 'SSH key (enter to skip): ' SSHKEY
  if [ "${SSHKEY}" == "" ] ; then 
    echo "#SETTING DEV SKIPPED" >> $FILE_ENV
    exit 0
  fi 

  if [ -f ${SSHKEY} ] ; then
    update_env $FILE_ENV "SSHKEY" $SSHKEY
  else
    echo "${SSHKEY} non trovata"
    exit 1
  fi
  
  read -p 'USER SERVER (root or sudo user): ' SRV_USER
  update_env $FILE_ENV "SRV_USER" $SRV_USER
    
  read -p 'USER SERVER WORKDIR: ' SRV_USER_WK
  if [ "${SRV_USER_WK}" == "" ] ; then
    $SRV_USER_WK=$SRV_USER
  fi
  update_env $FILE_ENV "SRV_USER_WK" $SRV_USER_WK

  read -p 'AWS IP EC2: ' SRV_HOST
  update_env $FILE_ENV "SRV_HOST" $SRV_HOST
}

download_wp(){
  curl -LkSs https://github.com/laravel/lumen/archive/master.zip -o lumen.zip
  
  unzip lumen.zip

  rm lumen.zip

  mv lumen-master lumen
}

main() {
  if [ -f "$FILE_ENV" ] ; then
    echo "[ERROR] file .env exist"
    exit 1
  fi

  parser $@

  touch $FILE_ENV

  update_env $FILE_ENV "ENV" "$ENV"
  update_env $FILE_ENV "APPNAME" "$APPNAME"
  update_env $FILE_ENV "DOMAIN" "$DOMAIN"
  update_env $FILE_ENV "DOCKERFILE_PATH" "."
  update_env $FILE_ENV "WORKDIR_USER" "www-data"
  update_env $FILE_ENV "WORKDIR_GROUP" "www-data"
  update_env $FILE_ENV "WORKDIRPATH" "/var/www/${APPNAME}"
  update_env $FILE_ENV "SOURCEPATH" "./lumen"
  update_env $FILE_ENV "CONTAINERPATH" "./container"
  update_env $FILE_ENV "VOLUMESPATH" "./container/data"

  if [ "$ENV" == "dev" ] ; then
    download_wp
    set_dev_env
  fi

  exit 0
}

main $@
