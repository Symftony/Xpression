default: install test stan

install:
	composer install

test:
	vendor/bin/phpunit

cs:
	vendor/bin/php-cs-fixer fix -vvv

analyse: test
	vendor/bin/phpmetrics --junit --report-html=docs/phpmetrics/index.html src
	vendor/bin/phpstan
