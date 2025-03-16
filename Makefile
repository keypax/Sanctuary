include .env

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

create-db-sanctuary-api-user:
	@docker-compose exec $(DB_HOST) psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -c "CREATE ROLE $(SANCTUARY_API_DB_USER) WITH LOGIN PASSWORD '$(SANCTUARY_API_DB_PASSWORD)';"
	@docker-compose exec $(DB_HOST) psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -c 'GRANT SELECT ON TABLE animal TO '''$(SANCTUARY_API_DB_USER)''';'
	@docker-compose exec $(DB_HOST) psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -c 'GRANT SELECT ON TABLE animal_breed TO '''$(SANCTUARY_API_DB_USER)''';'
	@docker-compose exec $(DB_HOST) psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -c 'GRANT SELECT ON TABLE animal_photo TO '''$(SANCTUARY_API_DB_USER)''';'
	@docker-compose exec $(DB_HOST) psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -c 'GRANT SELECT ON TABLE animal_species TO '''$(SANCTUARY_API_DB_USER)''';'
	@docker-compose exec $(DB_HOST) psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -c 'GRANT SELECT ON TABLE enclosure TO '''$(SANCTUARY_API_DB_USER)''';'

delete-db-sanctuary-api-user:
	@docker-compose exec $(DB_HOST) psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -c ' \
    	  REVOKE ALL PRIVILEGES ON ALL TABLES IN SCHEMA public FROM $(SANCTUARY_API_DB_USER); \
    	  REVOKE ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public FROM $(SANCTUARY_API_DB_USER); \
    	  REVOKE ALL PRIVILEGES ON SCHEMA public FROM $(SANCTUARY_API_DB_USER); \
    	  DROP ROLE IF EXISTS $(SANCTUARY_API_DB_USER);'

list-db-users:
	@docker-compose exec $(DB_HOST) psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -c 'SELECT rolname FROM pg_roles WHERE rolcanlogin;'

create-migration:
	docker-compose exec php php bin/console make:migration

migrate:
	docker-compose exec php php bin/console doctrine:migrations:migrate

cache-clear:
	docker-compose exec php php bin/console cache:clear