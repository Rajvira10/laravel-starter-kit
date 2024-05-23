FROM php:8.1 as php

RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
RUN docker-php-ext-install pdo pdo_pgsql bcmath

WORKDIR /var/dir
COPY . .

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

ENV PORT=8000

RUN docker-php-ext-install mysqli pdo pdo_mysql

ENTRYPOINT [ "Docker/entrypoint.sh" ]

