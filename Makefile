build:
	docker-compose build

start:
	docker-compose up -d

composer-install:
	docker-compose exec php composer install

stop:
	docker-compose down

run-tests:
	docker-compose exec php php bin/phpunit

create-db:
	docker-compose exec php php bin/console doctrine:database:drop --if-exists -f
	docker-compose exec php php bin/console doctrine:database:create
	docker-compose exec php php bin/console doctrine:schema:create
	docker-compose exec php php bin/console doctrine:fixtures:load
	docker-compose exec database psql -U postgres -d sanctuary -c "CREATE PUBLICATION sanctuary_publication_api FOR TABLE animal, animal_breed, animal_photo, animal_species, enclosure;"
	$(MAKE) cache-clear

cache-clear:
	docker-compose exec php php bin/console cache:clear