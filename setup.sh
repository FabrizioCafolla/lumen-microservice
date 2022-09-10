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
FILE_ENV_CONF="./env.cfg"
FILE_ENV="./.env"
SOURCEPATH="./source"

parser(){
    options=$(getopt -l "help,env:,appname:,domain:,lumen-version:,ssh-setup" -o "h e: a: d: v:" -a -- "$@")
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
            -v|--lumen-version)
                LUMEN_VERSION="${2}"
                ;;
            --ssh-setup)
              set_connection_from_local_to_prod
              exit 0
              ;;
            --)
                shift
                break;;
        esac
        shift
    done

    shift "$(($OPTIND -1))"

  if [ -f "$FILE_ENV_CONF" ] ; then
    echo "[INFO] Env setup: env.cfg -> .env"
    cp $FILE_ENV_CONF $FILE_ENV
    exit 0
  fi

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
  
  if [ -z $LUMEN_VERSION ] ; then
    read -p 'Lumen version (default master): ' LUMEN_VERSION
    if [[ "$LUMEN_VERSION" == "" ]] ; then
      LUMEN_VERSION="master"
    fi
  fi
}

update_env() {
  local _file=${1}
  local _key=${2}
  local _value=${3}
  echo "${_key}=${_value}" >> ${_file}
}

set_connection_from_local_to_prod() {
  while true; do
    read -p "Set the configurations for accessing the prod machine? (y,n) " yn
    case $yn in
        [Yy]* ) break;;
        [Nn]* ) exit;;
        * ) echo "Please answer yes or no.";;
    esac
  done
  
  printf "\n#SSH CONNECTION\n" >> $FILE_ENV

  read -p 'SSH key (enter to skip): ' SSHKEY
  if [ -f ${SSHKEY} ] ; then
    update_env $FILE_ENV  "SSHKEY" $SSHKEY
  else
    echo "${SSHKEY} not exist"
    exit 1
  fi

  read -p 'USER SERVER PROD (root or sudo user): ' SRV_USER
  update_env $FILE_ENV  "SRV_USER" $SRV_USER
    
  read -p 'USER SERVER PROD WORKDIR: ' SRV_USER_WK
  if [ "${SRV_USER_WK}" == "" ] ; then
    SRV_USER_WK=$SRV_USER
  fi
  update_env $FILE_ENV  "SRV_USER_WK" $SRV_USER_WK

  read -p 'IP SERVER PROD: ' SRV_HOST
  update_env $FILE_ENV  "SRV_HOST" $SRV_HOST
}

download_wp(){
  local _tag=${LUMEN_VERSION}
  if [[ "${_tag}" != "master" ]] ; then
    _tag="v${_tag}"
  fi

  curl -LkSs https://github.com/laravel/lumen/archive/${_tag}.zip -o lumen.zip
  
  unzip lumen.zip

  rm lumen.zip

  mv lumen-${LUMEN_VERSION} ${SOURCEPATH}
}

main() {
  parser $@

  echo "[INFO] setup env"
  touch $FILE_ENV_CONF 
  update_env $FILE_ENV_CONF  "ENV" "$ENV"
  update_env $FILE_ENV_CONF  "APPNAME" "$APPNAME"
  update_env $FILE_ENV_CONF  "DOMAIN" "$DOMAIN"
  update_env $FILE_ENV_CONF  "DOCKERFILE_PATH" "."
  update_env $FILE_ENV_CONF  "WORKDIR_USER" "www-data"
  update_env $FILE_ENV_CONF  "WORKDIR_GROUP" "www-data"
  update_env $FILE_ENV_CONF  "WORKDIRPATH" "/var/www/${APPNAME}"
  update_env $FILE_ENV_CONF  "SOURCEPATH" ${SOURCEPATH}
  update_env $FILE_ENV_CONF  "CONTAINERPATH" "./container"
  update_env $FILE_ENV_CONF  "VOLUMESPATH" "./container/data"
  update_env $FILE_ENV_CONF  "IMAGENAME" "microservice/${APPNAME}"
  cp $FILE_ENV_CONF $FILE_ENV

  if [ "$ENV" == "dev" ] ; then
    download_wp
    set_connection_from_local_to_prod
  fi

  exit 0
}

main $@
