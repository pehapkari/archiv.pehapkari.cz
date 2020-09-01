#!/usr/bin/env bash
php site-generator/bin/console dump-static-site
git subtree push --prefix output origin gh-pages
