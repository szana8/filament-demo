up:
	docker compose up -d --force-recreate

php:
	docker compose exec workspace bash

nuxt:
	docker compose exec nuxt bash

reverb:
	docker compose exec workspace php artisan reverb:start --debug