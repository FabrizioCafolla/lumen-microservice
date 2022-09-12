.PHONY: help

help: ## helper
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

.DEFAULT_GOAL := help

CONF ?= ./.env
VERSION = "1.0"

ifeq ($(which docker-compose),"")
	DOCKER_COMPOSE_BIN=docker-compose
else
	DOCKER_COMPOSE_BIN=docker compose
endif

version: ## version
	@echo ${VERSION}
##

ifeq ($(shell test -e $(CONF) && echo -n yes),yes)

include $(CONF)
export $(shell sed 's/=.*//' $(CONF))

TAG = "latest"

image_build: ## build immagine
	@docker build --tag "$(IMAGENAME):$(TAG)" \
		--no-cache \
		--target=$(ENV) \
		--build-arg ENV=$(ENV) \
		--build-arg APPNAME=$(APPNAME) \
		--build-arg DOMAIN=$(DOMAIN) \
		--build-arg WORKDIR_USER=$(WORKDIR_USER) \
		--build-arg WORKDIR_GROUP=$(WORKDIR_GROUP) \
		--build-arg WORKDIRPATH=$(WORKDIRPATH) \
		$(DOCKERFILE_PATH)

image_push: ## publish image
	@docker push "$(IMAGENAME):$(TAG)"

image_run:
	@docker run -d --rm -p 80:80 -p 9000:9000 --name $(APPNAME) $(IMAGENAME):$(TAG)

## ENV: DEV
ifeq ($(ENV),develop)
down: ## down containers
	$(DOCKER_COMPOSE_BIN) down

up:  ## up -d containers
	$(DOCKER_COMPOSE_BIN) up -d

build:  # build containers
	$(DOCKER_COMPOSE_BIN) build 

exec: ## enter in app container
	@docker exec -it $(APPNAME) /bin/bash

exec_mysql: ## enter in mysql container
	@docker exec -it mysql /bin/bash

ssh_setup:
	./setup.sh --ssh-setup

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
