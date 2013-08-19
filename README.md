zfAlbum
=======

Introduction
------------
This is an simple Album application developed by following Rob Allen's and Jason Grimes's tutorials.
Application deploys Doctrine 2, the ZF2 MVC layer and module systems.

Prerequisite
------------
- PHP 5.4
- Composer.

php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"


Installation
------------

Doctrine Schema validation
./vendor/bin/doctrine-module.bat orm:validate-schema

Doctrine Schema creation
 ./vendor/bin/doctrine-module.bat orm:schema-tool:create


Development
-----------
Start standalone server shipped with PHP 5.4

php -S localhost:8000 -t public

Access on http://localhost:8000

UnitTests
---------

Album UnitTests:

vendor/bin/phpunit.bat --configuration module/Album/test/

Application UnitTests:

vendor/bin/phpunit.bat --configuration module/Application/test/

Credits
-------

http://framework.zend.com/manual/2.0/en/user-guide/overview.html
http://www.jasongrimes.org/2012/01/using-doctrine-2-in-zend-framework-2/

