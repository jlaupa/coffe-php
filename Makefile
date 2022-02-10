all: help
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Launcher ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
##
##  Available actions:             Description
##

.PHONY: help
help : Makefile
	@sed -n 's/^##//p' $<

##  up:                     Launcher container coffee machine up
.PHONY: up
up:
	./docker/scripts/up.sh

##  test:                    Run test coffee

.PHONY: test
test:
	./docker/scripts/test.sh

##  up:                     Launcher container coffee machine stop
.PHONY: stop
stop:
	docker-compose stop

##  console:                Go console
.PHONY: console
console:
	docker exec -ti coffee_php-cli bash

##
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
##
