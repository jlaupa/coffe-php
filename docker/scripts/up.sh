#!/usr/bin/env bash
docker network create --driver=bridge coffee_net

docker build docker/images/php-cli -t coffee_php-cli
docker build docker/images/postgre -t coffee.postgre
docker-compose up -d
