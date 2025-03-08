build:
	docker-compose build

start:
	docker-compose up -d
	docker-compose exec php composer install

stop:
	docker-compose down

run-tests:
	docker-compose exec php php bin/phpunit

create-db:
	docker-compose exec php ./bin/console doctrine:database:drop --if-exists -f
	docker-compose exec php ./bin/console doctrine:database:create
	docker-compose exec php ./bin/console doctrine:schema:create
	docker-compose exec php ./bin/console doctrine:fixtures:load

cache-clear:
	docker-compose exec php ./bin/console cache:clear