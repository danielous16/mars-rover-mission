FROM php:8.0.5-fpm-alpine

ENV PHP_IDE_CONFIG "serverName=MarsRoverMission"

WORKDIR /var/www

# Configure php
RUN echo "date.timezone = UTC" >> /usr/local/etc/php/php.ini

# Install required system packages
RUN apk update \
    && apk add  --no-cache \
    git \
    curl \
    icu-dev \
    libxml2-dev \
    libzip-dev \
    g++ \
    make \
    autoconf
RUN docker-php-source extract
RUN docker-php-source delete
RUN docker-php-ext-install pdo_mysql soap intl zip

RUN yes | pecl install xdebug \
    && echo "zend_extension=xdebug" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "[xdebug]" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin

RUN rm -rf /tmp/*

COPY . /var/www