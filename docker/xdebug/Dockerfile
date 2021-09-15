FROM php:7.4-cli-alpine

RUN set -ex \
    && apk update \
    && apk add --no-cache git mysql-client curl openssh-client icu libpng freetype libzip \
       libjpeg-turbo postgresql-dev libffi-dev libsodium \
    && apk add --no-cache --virtual build-dependencies icu-dev libxml2-dev freetype-dev libzip-dev libpng-dev \
        libjpeg-turbo-dev g++ make autoconf libsodium-dev\
    && mkdir /src && cd /src && git clone https://github.com/xdebug/xdebug.git \
    && cd xdebug \
    && sh ./rebuild.sh \
    && docker-php-source extract \
    && docker-php-ext-enable xdebug\
    && docker-php-source delete \
    && cd  / && rm -fr /src \
    && apk del build-dependencies \
    && rm -rf /tmp/*

USER root