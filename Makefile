UID=$(shell id -u)
GID=$(shell id -g)
DOCKER_PHP_SERVICE=php-fpm

start: erase cache-folders build composer-install up

erase:
		docker-compose down -v

build:
		docker-compose build && \
		docker-compose pull

cache-folders:
		mkdir -p ~/.composer && chown ${UID}:${GID} ~/.composer

composer-install:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} composer install

init: ## init environment
	docker-compose exec --user=${UID} ${DOCKER_PHP_SERVICE} sh -c "php bin/console pccom:environment:init"

up:
		docker-compose up -d

stop:
		docker-compose stop

down: ## alias stop
		make stop

bash:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} sh

root:
		docker-compose run --rm -u 0:0 ${DOCKER_PHP_SERVICE} sh

logs:
		docker-compose logs -f ${DOCKER_PHP_SERVICE}

fix: ## fix automatical errors from ganchudo
		docker-compose exec --user=${UID} ${DOCKER_PHP_SERVICE} sh -c "./bin/fix-phpcbf"

fix-perms:
		docker-compose run --rm -u ${0}:${0} ${DOCKER_PHP_SERVICE} sh -c "chown -Rvf ${UID}:${GID} /var/app/*"

fix_all: ## fix automatical errors from ganchudo
		docker-compose exec --user=${UID} ${DOCKER_PHP_SERVICE} sh -c "./vendor/bin/phpcbf"

test_unit:
	    docker-compose exec --user ${UID} ${DOCKER_PHP_SERVICE} vendor/bin/phpunit

consume-commands:
	docker-compose exec --user ${UID}:${GID} ${DOCKER_PHP_SERVICE} console messenger:consume commands_low --bus=execute_command.bus --limit=100 --time-limit=60 -vv

consume-events:
	docker-compose exec --user ${UID}:${GID} ${DOCKER_PHP_SERVICE} console messenger:consume events --bus=execute_event.bus --limit=100 --time-limit=60 -vv

consume-commands-non-stop:
	docker-compose exec --user ${UID}:${GID} ${DOCKER_PHP_SERVICE} console messenger:consume commands_low --bus=execute_command.bus --limit=100  -vv

consume-events-non-stop:
	docker-compose exec --user ${UID}:${GID} ${DOCKER_PHP_SERVICE} console messenger:consume events --bus=execute_event.bus --limit=100 -vv

test_unit_coverage:
	docker-compose exec --user ${UID}:${GID} ${DOCKER_PHP_SERVICE} vendor/bin/phpunit --coverage-text

phinx_migrate:
	docker-compose exec --user=${UID} ${DOCKER_PHP_SERVICE} sh -c "phinx migrate"


phinx_rollback:
	docker-compose exec --user=${UID} ${DOCKER_PHP_SERVICE} sh -c "phinx rollback"

phinx_fixtures:
	docker-compose exec --user=${UID} ${DOCKER_PHP_SERVICE} sh -c "phinx seed:run"