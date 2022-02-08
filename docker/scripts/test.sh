#!/usr/bin/env bash

HOST_USER_ID=$(id -u "$(whoami)")
HOST_GROUP_ID=$(id -g "$(whoami)")

docker run                                      \
    --rm --interactive --tty                    \
    --user "${HOST_USER_ID}:${HOST_GROUP_ID}"   \
    --network coffeee_net                \
    --volume "$PWD":/app                        \
    --workdir /app                              \
    coffeee.php-cli                      \
    php vendor/bin/phpunit "$@"