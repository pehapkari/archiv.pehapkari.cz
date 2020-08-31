# inspiration: https://github.com/rectorphp/getrector.org/blob/master/Dockerfile

## This build stage contains only prepared environment, without sorce codes
FROM php:7.4-apache as dev

LABEL maintainer="Jan Mikeš <j.mikes@me.com>"

WORKDIR /var/www/pehapkari.cz

# Apache config
COPY ./.docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Install nodejs + php extensions
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        g++ \
        zlib1g-dev \
        libicu-dev \
        libzip-dev \
    && pecl -q install \
        zip \
    && docker-php-ext-enable zip

# Installing composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_MEMORY_LIMIT=-1

# Entrypoint
COPY ./.docker/docker-php-entrypoint /usr/local/bin/docker-php-entrypoint

RUN chmod 777 /usr/local/bin/docker-php-entrypoint
