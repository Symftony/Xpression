default: install test stan

install:
	composer install

test:
	vendor/bin/phpunit

cs:
	vendor/bin/php-cs-fixer fix -vvv

analyse:
	vendor/bin/phpstan
