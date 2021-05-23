Task Description
-----------------
Data export from xml to redis. This application requires your local redis-server setup before you can use it.
The application is looking for Redis IP '127.0.0.1'

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
