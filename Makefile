THIS_FILE := $(lastword $(MAKEFILE_LIST))
.PHONY: up stop logs composer-install migrate tests-schema load-fixtures run-tests
up:
	docker-compose -f docker-compose.yaml up -d $(c)
stop:
	docker-compose -f docker-compose.yaml stop $(c)
logs:
	docker-compose -f docker-compose.yaml logs --tail=100 -f $(c)
composer-install:
	docker exec -ti php81-container composer install
migrate:
	docker exec -ti php81-container php bin/console doctrine:migrations:migrate
tests-schema:
	docker exec -ti php81-container php bin/console --env=test doctrine:schema:create
load-fixtures:
	docker exec -ti php81-container php bin/console --env=test doctrine:fixtures:load
run-tests:
	docker exec -ti php81-container php bin/phpunit tests/Controller



