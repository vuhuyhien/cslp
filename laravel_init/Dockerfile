FROM php:alpine

RUN apk update \
    && apk add --no-cache --virtual bash \
    && apk add --no-cache --virtual gettext \
    && docker-php-ext-install pdo_mysql bcmath

COPY laravel_init.sh /usr/bin

RUN chmod +x /usr/bin/laravel_init.sh

WORKDIR /var/www

CMD laravel_init.sh