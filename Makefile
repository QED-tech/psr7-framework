server:
	php -S localhost:3030 -t public/
test:
	vendor/bin/phpunit

lint:
	composer phpcs

lint-fix:
	composer cs-fix

up:
	docker-compose up -d

down:
	docker-compose down

docker-build:
	docker-compose build

down-clear:
	docker-compose down -v --remove-orphans