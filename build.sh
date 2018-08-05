#!/bin/sh

set -u
set -e

if [ -f composer.phar ]; then
  php composer.phar self-update
else
  php -r "readfile('https://getcomposer.org/installer');" | php
fi

php composer.phar install

./vendor/bin/doctrine-migrations migrations:migrate --no-interaction
