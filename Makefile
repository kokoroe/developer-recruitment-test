# Kokoroe Recruitment

composer.phar:
	@curl -sS https://getcomposer.org/installer | php

vendor: composer.phar
	@php composer.phar install

test: vendor
	@phpunit --coverage-text --coverage-html build/coverage
