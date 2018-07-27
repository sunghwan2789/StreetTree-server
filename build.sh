#!/bin/sh

if [ -f composer.phar ]; then
  php composer.phar self-update
else
  curl -sL https://getcomposer.org/installer > composer-installer
  php composer-installer
fi

php composer.phar install
