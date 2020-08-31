FROM php:7.4-apache as dev

LABEL maintainer="Jan Mikeš <j.mikes@me.com>"

WORKDIR /var/www/pehapkari.cz

COPY ./.docker/apache.conf /etc/apache2/sites-available/000-default.conf

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

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_MEMORY_LIMIT=-1

COPY ./.docker/docker-php-entrypoint /usr/local/bin/docker-php-entrypoint

RUN chmod 777 /usr/local/bin/docker-php-entrypoint
