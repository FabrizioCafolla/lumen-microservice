# import deploy config
# You can change the default deploy config with `make cnf="deploy_special.env" release`
env ?= ./.develop.env
include $(env)
export $(shell sed 's/=.*//' $(env))

CMD=/bin/sh
SRV=

.PHONY: help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

exec: ## Exec container
	docker-compose exec $(SRV) $(CMD)

run: ## Run container
	docker-compose run $(SRV)

build: ## Build container
	docker-compose build $(SRV)

up: ## Up container
	docker-compose up -d $(SRV)

down: ## Down container
	docker-compose down

rebuild: down build up

init: build up
	docker-compose exec laravel /bin/sh -c "cp backend/.env.example backend/.env ; chown :www-data /var/www && chmod -R 777 storage && chmod -R 777 bootstrap/cache ; php artisan key:generate && php artisan config:cache"