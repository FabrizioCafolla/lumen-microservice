.PHONY: help

help: ## helper
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

.DEFAULT_GOAL := help

CONF ?= ./.env
VERSION = "1.0"

version: ## version
	@echo ${VERSION}
##

ifeq ($(shell test -e $(CONF) && echo -n yes),yes)

include $(CONF)
export $(shell sed 's/=.*//' $(CONF))

TAG = "latest"

DB_HOST = ""
DB_NAME = ""
DB_USER = ""
DB_PASS = ""

image_build: ## build immagine
	@docker build --tag "$(IMAGENAME):$(TAG)" \
		--quiet \
		--no-cache \
		--target="pro" \
		--build-arg ENV=$(ENV) \
		--build-arg APPNAME=$(APPNAME) \
		--build-arg DOMAIN=$(DOMAIN) \
		--build-arg WORKDIR_USER=$(WORKDIR_USER) \
		--build-arg WORKDIR_GROUP=$(WORKDIR_GROUP) \
		--build-arg WORKDIRPATH=$(WORKDIRPATH) \
		--build-arg DB_HOST=$(DB_HOST) \
		--build-arg DB_NAME=$(DB_NAME) \
		--build-arg DB_USER=$(DB_USER) \
		--build-arg DB_PASS=$(DB_PASS) \
		$(DOCKERFILE_PATH)

image_push: ## publish image
	@docker push "$(IMAGENAME):$(TAG)"



## ENV: DEV
ifeq ($(ENV),dev)
down: ## down containers
	@docker-compose down

up:  ## up -d containers
	@docker-compose up -d

build:  # build containers
	@docker-compose build

exec: ## entra nel container
	@docker exec -it $(APPNAME) /bin/bash

ssh_root: ## connessione ssh con l'utenza root o sudoers
	@ssh -i $(SSHKEY) $(SRV_USER)@$(SRV_HOST)

ssh: ## connessione ssh con l'utente proprietario della workdir
	@ssh -i $(SSHKEY) $(SRV_USER_WK)@$(SRV_HOST)

deploy: down build up ## rebuild containers

endif

endif
##

## APP NON CONFIGURATA
ifneq ($(shell test -e $(CONF) && echo -n yes),yes)
setup: #first install
	@chmod +x ./setup.sh
	@./setup.sh
	@cp lumen/.env.example lumen/.env

manual: ## manuale configurazione 
	@echo "read Readme.md"
	@echo "Missing .env file"
endif
##
