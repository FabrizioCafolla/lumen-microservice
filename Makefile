# import deploy config
# You can change the default deploy config with `make cnf="deploy_special.env" release`
dev ?= ./.env
include $(dev)
export $(shell sed 's/=.*//' $(dev))

COMMAND=/bin/sh
SERVICE=

.PHONY: help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

exec: ## Exec container
	docker-compose -p $(APP_NAME) exec $(SERVICE) $(COMMAND)

run: ## Run container
	docker-compose -p $(APP_NAME) run $(SERVICE)

build: ## Build container
	docker-compose -p $(APP_NAME) build $(SERVICE)

rebuild: ## Rebuild container
	docker-compose -p $(APP_NAME) up -d --build $(SERVICE)

up: ## Up container
	docker-compose -p $(APP_NAME) up -d $(SERVICE)

down: ## Down container
	docker-compose -p $(APP_NAME) down