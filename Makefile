start:
	php artisan serve --host 0.0.0.0
setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	npm install
deploy:
	git push heroku
lint:
	composer run-script phpcs -- --standard=PSR12 tests
test:
	php artisan test