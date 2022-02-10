docker run                                      \
    --rm --interactive --tty                    \
    --network coffee_net               \
    --volume "$PWD":/app                        \
    --workdir /app                              \
    coffee_php-cli                     \
    php vendor/bin/phpunit "$@"
