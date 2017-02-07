# docker-php

[![Build Status](https://travis-ci.org/ryu-blacknd/docker-php.svg?branch=master)](https://travis-ci.org/ryu-blacknd/docker-php)

Docker image: LAMP+ for PHP Developers.

https://hub.docker.com/r/ryublacknd/php/

## Environment

* CentOS 6
* Apache 2.2
* PHP (Tag: [5.5](https://github.com/ryu-blacknd/docker-php/tree/master/5.5), [5.6](https://github.com/ryu-blacknd/docker-php/tree/master/5.6), [7.0](https://github.com/ryu-blacknd/docker-php/tree/master/7.0))
* PHP - Japanese Support (i.e. ipa-gothic-fonts)
* MySQL 5.1
* phpMyAdmin 4
* ImageMagick 6

## Usage

start this container

```
$ docker run -d -v ${PWD}/html:/var/www/html -p 80:80 -p 443:443 ryublacknd/php:5.6
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
