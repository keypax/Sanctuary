FROM php:8.4-fpm-alpine

RUN apk add --no-cache --update \
    autoconf \
    gcc \
    g++ \
    make \
    icu-dev \
    libzip-dev \
    postgresql-dev \
    git \
    unzip \
    linux-headers \
  && docker-php-ext-install intl pdo_pgsql zip opcache

RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . /app