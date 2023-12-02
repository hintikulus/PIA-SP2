############################################################
# PROJECT ##################################################
############################################################
#.PHONY: project install setup clean
#
#project: install setup
DIR_DOCKER=docker
PHP_CONTAINER_NAME=PIA-SP2_apache

# start aplikace
up:
	cd "${DIR_DOCKER}" && docker-compose up

down stop:
	cd "${DIR_DOCKER}" && docker-compose down

#
install:
	cd "${DIR_DOCKER}" && docker exec -it "${PHP_CONTAINER_NAME}" bash -c "composer install"

setup:
	mkdir -p var/tmp var/log
	chmod +0777 var/tmp var/log

clean:
	find var/tmp -mindepth 1 ! -name '.gitignore' -type f,d -exec rm -rf {} +
	find var/log -mindepth 1 ! -name '.gitignore' -type f,d -exec rm -rf {} +

delete-cache dc:
	find var/tmp -mindepth 1 ! -name '.gitignore' -type f,d -exec rm -rf {} +

phpstan ps:
	cd "${DIR_DOCKER}" && docker exec -it "${PHP_CONTAINER_NAME}" bash -c "vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=512M app tests/toolkit"

tests test nt:
	cd "${DIR_DOCKER}" && docker exec -it "${PHP_CONTAINER_NAME}" bash -c "vendor/bin/tester -s -p php --colors 1 -C tests"

coverage:
	cd "${DIR_DOCKER}" && docker exec -it "${PHP_CONTAINER_NAME}" bash -c "vendor/bin/tester -s -p phpdbg --colors 1 -C --coverage ./coverage.xml --coverage-src ./app tests"

bash b:
	cd "${DIR_DOCKER}" && docker exec -it "${PHP_CONTAINER_NAME}" bash -c "umask 000 && bash"

migrate m:
	cd "${DIR_DOCKER}" && docker exec -it "${PHP_CONTAINER_NAME}" bash -c "NETTE_DEBUG=1 bin/console migrations:migrate --no-interaction"

mig-create mc:
	cd "${DIR_DOCKER}" && docker exec -it "${PHP_CONTAINER_NAME}" bash -c "NETTE_DEBUG=1 bin/console migrations:generate"

proxy-gen pg:
	cd "${DIR_DOCKER}" && docker exec -it "${PHP_CONTAINER_NAME}" bash -c "NETTE_DEBUG=1 bin/console orm:generate-proxies"

websocket-start ws:
	cd "${DIR_DOCKER}" && docker exec -it "${PHP_CONTAINER_NAME}" bash -c "NETTE_DEBUG=1 bin/console ipub:websockets:start"
