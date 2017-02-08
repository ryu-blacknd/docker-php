# 日本語PHP開発環境 - バージョン別

[![Build Status](https://travis-ci.org/ryu-blacknd/docker-php.svg?branch=master)](https://travis-ci.org/ryu-blacknd/docker-php)

PHP開発者用の日本語対応Dockerイメージ。  
LAMP環境に加え、ありがちなパッケージもインストール済み。  

https://hub.docker.com/r/ryublacknd/php/

## 概要

* CentOS 6
* Apache 2.2
* PHP（Tag: [5.3](https://github.com/ryu-blacknd/docker-php/tree/master/5.3), [5.4](https://github.com/ryu-blacknd/docker-php/tree/master/5.4), [5.5](https://github.com/ryu-blacknd/docker-php/tree/master/5.5), [5.6](https://github.com/ryu-blacknd/docker-php/tree/master/5.6), [7.0](https://github.com/ryu-blacknd/docker-php/tree/master/7.0),  [7.1](https://github.com/ryu-blacknd/docker-php/tree/master/7.1), [latest](https://github.com/ryu-blacknd/docker-php/tree/master/7.1)）
* MySQL 5.1
* phpMyAdmin 4
* ImageMagick 6
* 日本語サポート（IPAフォント等）
* その他（git, vim, curl, wget等）

## 起動方法

dockerコマンドで起動する場合：

```
$ docker run -d -v ./html:/var/www/html -p 8080:80 -p 8443:443 ryublacknd/php:5.6
```

docker-composeコマンドで起動する場合：

```
$ docker-compose up -d
```

## 使い方

LinuxやDocker for Windowsでは、localhostでアクセスできる。

```
http://localhost:8080/
```

PHPスクリプトは、ホストの`html`ディレクトリにファイルを置くだけで動作する。

メール送信テストは[MailCatcher](https://mailcatcher.me/)がオススメ。
