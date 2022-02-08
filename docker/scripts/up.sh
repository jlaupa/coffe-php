#!/usr/bin/env bash
docker network create --driver=bridge coffeee_net

docker build docker/images/php-cli -t coffeee_php-cli
docker build docker/images/mysql -t coffeee.mysql
docker-compose up -d
