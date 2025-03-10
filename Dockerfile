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
    libpng-dev \
    freetype-dev \
    libjpeg-turbo-dev

RUN docker-php-ext-configure gd \
      --with-freetype \
      --with-jpeg && \
    docker-php-ext-install intl pdo_pgsql zip opcache gd

RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . /app