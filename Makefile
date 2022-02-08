all: help
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Launcher ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
##
##  Available actions:             Description
##

.PHONY: help
help : Makefile
	@sed -n 's/^##//p' $<

##  up:                     Launcher container coffe machine up
.PHONY: up
up:
	./docker/scripts/up.sh

##  tests:                  Run Tests
.PHONY: test
test:
	./docker/scripts/test.sh

##  console:                Go console
.PHONY: console
console:
	./docker/scripts/console.sh

##  composer:               Go composer
.PHONY: composer
composer:
	./docker/scripts/composer.sh


##
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
##
