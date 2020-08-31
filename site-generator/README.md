# Web of Czech PHP Community

[![Build Status](https://img.shields.io/travis/pehapkari/pehapkari.cz/master.svg?style=flat-square)](https://travis-ci.org/pehapkari/pehapkari.cz)

We're family of PHP developers from the Czech Republic, learning from each other on meetups and trainings.
We meet once a month in Prague, Brno and less often 4 other cities.

## Install

```bash
# install PHP dependencies
composer install

# install NPM dependencies
yarn install

# build assets + live rebuild
yarn run watch

# final step - run the website
php -S localhost:8000 -t public
```

Open [localhost:8000](http://localhost:8000) to see if it worked!

## Run via Docker

```
docker-compose up
```

**Project** is available on [localhost:8080](http://localhost:8080) including live rebuild (aka watch).

## Production build

Publicly, application is served as static, plaid old and good HTML+CSS.

This command generates static files, into **/output** directory:
```
bin/console dump-static-site
```
