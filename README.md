zfAlbum
=======

Introduction
------------

This is a simple Album application presented in [Rob Allen's](http://framework.zend.com/manual/2.0/en/user-guide/overview.html)
and [Jason Grimes's](http://www.jasongrimes.org/2012/01/using-doctrine-2-in-zend-framework-2/) tutorials.
However, all backend calls are done through API server by using backbone on front end

Application deploys Doctrine 2 and phly/phly-restfully module on backend.

The following standards used for RESTful JSON APIs:

- [HAL](http://stateless.co/hal_specification.html), used for creating
  hypermedia links
- [Problem API](http://tools.ietf.org/html/draft-nottingham-http-problem-02),
  used for reporting API problems
- [CORS](http://en.wikipedia.org/wiki/Cross-origin_resource_sharing),
  used for "cross-domain" requests

Prerequisite
------------

- MySQL
- PHP 5.4

Installation
------------

```bash
git clone https://github.com/denisura/zfAlbum.git tmp
cd tmp&&php composer.phar install --dev
```

Configuration
-------------
Set DB connection params in config/autoload/doctrine.local.php

Default values are:

    host     : localhost
    port     : 3306
    user     : root
    password :
    dbname   : zfalbum


Schema deployment
------------

Doctrine Schema validation

```bash
./vendor/bin/doctrine-module.bat orm:validate-schema
```

Doctrine Schema creation

```bash
 ./vendor/bin/doctrine-module.bat orm:schema-tool:create
```

Development
-----------
Start standalone server shipped with PHP 5.4

1. Run API server on port 8080:

```bash
php -S localhost:8080 -t app
```

2. Run web server:

```bash
php -S localhost -t public
```

Web Access on http://localhost

UnitTests
---------

Album UnitTests:

```bash
vendor/bin/phpunit.bat --configuration module/Album/test/
```

Application UnitTests:

```bash
vendor/bin/phpunit.bat --configuration module/Application/test/
```

API Usage
-------

### Add new album

```bash
curl -X POST --data "title=Yesterday&artist=beatles"  --header "Accept:application/json" http://localhost:8080/v1/albums
```

*Response:*

```json
{
   "id":27,
   "artist":"beatles",
   "title":"Yesterday",
   "_links":{
      "self":{
         "href":"http:\/\/localhost:8080\/v1\/albums\/27"
      }
   }
}
```

### Replace existing album

```bash
curl -X PUT --data "title=Help&artist=beatles"  --header "Accept:application/json" http://localhost:8080/v1/albums/27
```

*Response:*

```json
{
   "id":27,
   "artist":"beatles",
   "title":"Help",
   "_links":{
      "self":{
         "href":"http:\/\/localhost:8080\/v1\/albums\/27"
      }
   }
}
```

### Update only some property of existing album

```bash
curl -X PATCH --data "title=Girl"  --header "Accept:application/json" http://localhost:8080/v1/albums/27
```

*Response:*

```json
{
   "id":27,
   "artist":"beatles",
   "title":"Girl",
   "_links":{
      "self":{
         "href":"http:\/\/localhost:8080\/v1\/albums\/27"
      }
   }
}
```

### Delete album

```bash
curl -X DELETE --header "Accept:application/json" http://localhost:8080/v1/albums/5
```

### Delete all albums

```bash
curl -X DELETE --header "Accept:application/json" "http://localhost:8080/v1/albums"
```
