# docker-php

[![Build Status](https://travis-ci.org/ryublacknd/docker-php.svg?branch=master)](https://travis-ci.org/ryublacknd/docker-php)

Docker image: LAMP+ for PHP Developers.

https://hub.docker.com/r/ryublacknd/php/

## Environment

* CentOS 6 (64bit)
* Apache 2.4 + SSL
* PHP 5.5
* MySQL 5.6
* phpMyAdmin 4.6
* ImageMagick 6.7
* Postfix 2.6

## Usage

```
$ docker run -d -v ${PWD}/html:/var/www/html -p 80:80 -p 443:443 -p 25:25 ryublacknd/php
```
