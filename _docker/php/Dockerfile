FROM php:8.4-fpm

RUN apt-get update
RUN docker-php-ext-install pdo pdo_mysql

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

ARG USER_ID=1000
ARG GROUP_ID=1000

RUN groupadd -g ${GROUP_ID} app \
    && useradd -u ${USER_ID} -g app -m app

USER app
