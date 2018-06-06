FROM php:fpm-alpine

ENV PHPIZE_DEPS autoconf file g++ gcc libc-dev make pkgconf re2c php7-dev php7-pear \
        yaml-dev pcre-dev zlib-dev libmemcached-dev cyrus-sasl-dev

RUN apk update && apk add libmcrypt-dev mysql-client zlib-dev libpng-dev \
    && docker-php-ext-install pdo_mysql bcmath zip gd
RUN apk update && apk add openssl-dev g++ make \
    && apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && apk del pcre-dev ${PHPIZE_DEPS}

WORKDIR /var/www