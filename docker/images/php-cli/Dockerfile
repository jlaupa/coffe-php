FROM php:7.3-fpm
RUN apt-get update && apt-get install -y apt-transport-https
RUN apt-get update \
    && apt-get -y install libssl-dev libc-client2007e-dev libkrb5-dev curl git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod 755 /usr/local/bin/composer \
    && docker-php-ext-install -j$(nproc) bcmath
    RUN apt-get install -y \
            libzip-dev \
            zip \
      && docker-php-ext-configure zip --with-libzip \
      && docker-php-ext-install zip

# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Install PECL extensions
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug \
    && echo "zend_extension=xdebug.so" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN apt-get install -y libxml2-dev
RUN docker-php-ext-install simplexml xmlwriter sockets

RUN apt-get update \
 && apt-get install -y --no-install-recommends \
    supervisor

COPY ./supervisor/supervisord.conf /etc/supervisor
COPY ./supervisor/programs/* /etc/supervisor/conf.d/

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]