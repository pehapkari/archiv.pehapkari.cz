#!/usr/bin/env bash
php site-generator/bin/console dump-static-site
mv site-generator/output public
