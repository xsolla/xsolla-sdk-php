ARG PHP_VERSION=7.3
FROM php:${PHP_VERSION}-fpm-alpine

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions xdebug curl soap pcov zip

RUN apk add --no-cache zip libzip-dev

RUN echo 'phar.readonly=0' >> /usr/local/etc/php/php.ini-production && cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# Install composer
COPY --from=composer:1 /usr/bin/composer /usr/bin/composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app/xsolla-sdk-php