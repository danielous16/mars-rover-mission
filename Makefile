.PONY: build init-database composer-install composer-update test start stop docker-build

build: docker-build start composer-install init-database

composer-install:
	@docker exec mars_rover_mission_php composer install

composer-update:
	@docker exec mars_rover_mission_php composer update

test:
	@docker exec mars_rover_mission_php bin/phpunit

init-database:
	@docker exec mars_rover_mission_mysql bash -c "chmod 0775 docker-entrypoint-initdb.d/init-database.sh"
	@docker exec mars_rover_mission_mysql bash -c "./docker-entrypoint-initdb.d/init-database.sh"

start:
	docker-compose up -d

stop:
	docker-compose stop

docker-build:
	docker-compose build