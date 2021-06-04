build: ## Build Docker containers
	docker-compose build --no-cache

start: ## Start Docker containers
	docker-compose up -d

stop: ## Stop Docker containers
	docker-compose down

stop-with-volumes: ## Stop Docker containers and removes volumes
	docker-compose down --remove-orphans --volumes

dependencies: ## Run Composer install
	docker-compose run --rm coins composer install

migrations-dev: ## Run DB migrations in dev environment
	docker-compose run --rm coins bin/console doctrine:migrations:migrate --env=dev --no-interaction

migrations-test: ## Run DB migrations in test environment
	docker-compose run --rm coins bin/console doctrine:migrations:migrate --env=test --no-interaction

clear-cache: ## Clear cache in dev environment
	docker-compose run --rm coins bin/console cache:clear --env=dev

clear-cache-test: ## Clear cache in test environment
	docker-compose run --rm coins bin/console cache:clear --env=test

test: ## Run the testsuite
	docker-compose run --rm coins vendor/bin/phpunit --testdox

test-coverage: ## Run the testsuite showing coverage and exporting it in html (in var/coverage)
	docker-compose run --rm coins vendor/bin/phpunit --coverage-html=var/coverage --coverage-text

static-analysis: ## Run static analysis with PSalm
	docker-compose run --rm coins vendor/bin/psalm

mutations: ## Run mutation testing with Infection
	docker-compose run --rm coins vendor/bin/infection --threads=4

shell: ## Bash into the container
	docker-compose run --rm coins bash

# Based on https://suva.sh/posts/well-documented-makefiles/
help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

