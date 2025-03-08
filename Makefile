create-db:
	docker-compose exec php ./bin/console doctrine:database:drop --if-exists -f
	docker-compose exec php ./bin/console doctrine:database:create
	docker-compose exec php ./bin/console doctrine:schema:create