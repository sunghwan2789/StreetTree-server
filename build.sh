#!/bin/sh

set -u
# set -e

if [ -f composer.phar ]; then
  php composer.phar self-update
else
  php -r "readfile('https://getcomposer.org/installer');" | php
fi

# windows docker fails phar:// protocol
php composer.phar install || true
