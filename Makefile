#!/usr/bin/env make
# SHELL = sh -xv

PHP_VERSION = 8.2
TAG := muscobytes/laravel-takeads-api/php-cli-$(PHP_VERSION)

.PHONY: help
help:  ## Shows this help message
	@echo "  Usage: make [target]\n\n  Targets:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' "$(shell pwd)/Makefile" | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "   🔸 \033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: build
build:
	docker build \
		--file "$(shell pwd)/.docker/php/$(PHP_VERSION)/Dockerfile" \
		--tag $(TAG) \
		.

.PHONY: shell
shell:
	docker run -ti -v "$(shell pwd):/var/www/html" $(TAG) sh

.PHONY: test
test:
	docker run -ti -v "$(shell pwd):/var/www/html" $(TAG) vendor/bin/phpunit

.PHONY: tag
tag:
	git tag v$(shell cat ./composer.json | jq -r .version)

.PHONY: untag
untag:
	git tag -d v$(shell cat ./composer.json | jq -r .version)
