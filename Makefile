server:
	php -S localhost:3030 -t public/
test:
	vendor/bin/phpunit

lint:
	composer phpcs

lint-fix:
	composer cs-fix