start:
	php artisan serve --host 0.0.0.0
setup:
	composer install
	cp -n .env.example .env || true
	php artisan key:gen --ansi
	php artisan migrate
	php artisan db:seed
	npm install
deploy:
	git push heroku
lint:
	composer run-script phpcs -- --standard=PSR12 tests app
test:
	php artisan test
migrate:
	php artisan migrate
reset_db:
	php artisan migrate:reset