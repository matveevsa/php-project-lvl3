start:
	php artisan serve --host 0.0.0.0
deploy:
	git push heroku
lint:
	composer phpcs
test:
	php artisan test