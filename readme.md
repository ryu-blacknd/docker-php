# docker-php

[![Build Status](https://travis-ci.org/ryu-blacknd/docker-php.svg?branch=master)](https://travis-ci.org/ryu-blacknd/docker-php)

Docker image: LAMP+ for PHP Developers.

https://hub.docker.com/r/ryublacknd/php/

## Environment

* CentOS
* Apache
* PHP (5.5/5.6)
* MySQL
* phpMyAdmin
* ImageMagick

## Usage

start this container

```
$ docker run -d -v ${PWD}/html:/var/www/html -p 80:80 ryublacknd/php:5.6
```

or

```
$ docker-compose up -d
```

## Access

Apache

http://develop.local/

phpMyAdmin

http://develop.local/phpMyAdmin/
