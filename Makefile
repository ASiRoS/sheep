migrate:
	docker-compose exec php php artisan migrate:fresh
up-build:
	docker-compose up --build
