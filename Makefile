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

image_build: ## build immagine
	@docker build --tag "$(APPNAME):$(TAG)" \
		--target="$(ENV)" \
		--quiet \
		--no-cache \
		--build-arg ENV=$(ENV) \
		--build-arg APPNAME=$(APPNAME) \
		--build-arg DOMAIN=$(DOMAIN) \
		--build-arg WORKDIR_USER=$(WORKDIR_USER) \
		--build-arg WORKDIR_GROUP=$(WORKDIR_GROUP) \
		--build-arg WORKDIRPATH=$(WORKDIRPATH) \
		$(DOCKERFILE_PATH)

image_push:
	@docker push "$(APPNAME):$(TAG)"

publish: #pusblish
	@docker push $(APPNAME)/website:latest


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

manual: ## manuale configurazione 
	@echo "read Readme.md"
	@echo "Missing .env file"
endif
##
