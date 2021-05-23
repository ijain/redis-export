Task Description
-----------------
Data export from xml to redis

Environment
-------------
OS: Linux Mint 17.3 (64-bit)

PHP version: 7.4

PHPUnit version: 9.0

Redis Package: https://packagist.org/packages/predis/predis

Installation
--------------
composer install

Test Commands
---------------
php vendor/bin/phpunit

Run application command
------------------------
For printing: ./export.sh -v ./xml/config.xml
Without printing: ./export.sh ./xml/config.xml
