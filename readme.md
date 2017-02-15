# 日本語PHP+DB開発環境 - バージョン別

[![Build Status](https://travis-ci.org/ryu-blacknd/docker-php.svg?branch=master)](https://travis-ci.org/ryu-blacknd/docker-php)

PHP+DB開発者用のDockerイメージ。
すぐにPHP+DB開発を開始できる状態で起動する。
LAMP環境に加え、日本語向けパッケージもインストール済み。
動作検証用に公式サポートの終了したバージョンも揃えてある。

https://hub.docker.com/r/ryublacknd/php/

## 概要

* CentOS 6
* Apache 2.2
* PHP（Tag: [5.3](https://github.com/ryu-blacknd/docker-php/tree/master/5.3), [5.4](https://github.com/ryu-blacknd/docker-php/tree/master/5.4), [5.5](https://github.com/ryu-blacknd/docker-php/tree/master/5.5), [5.6](https://github.com/ryu-blacknd/docker-php/tree/master/5.6), [7.0](https://github.com/ryu-blacknd/docker-php/tree/master/7.0),  [7.1](https://github.com/ryu-blacknd/docker-php/tree/master/7.1), [latest](https://github.com/ryu-blacknd/docker-php/tree/master/7.1)）
* MySQL 5.1 / 5.5 (PHP 5.3環境ではMySQL 5.1)
* phpMyAdmin 4
* GD, ImageMagick 6
* 日本語フォント (IPAゴシック、IPA明朝、VLゴシック)
* その他 (git, vim, curl, wget, freetype, composer等)

## 起動方法

##### dockerコマンドで起動する場合

作業するディレクトリ (フォルダ) を作成し、その中で以下コマンドを実行。

```
$ docker run -d -v ./html:/var/www/html -v .mysql_data:/var/lib/mysql -p 80:80 -p 443:443 ryublacknd/php:7.0
```

##### docker-composeコマンドで起動する場合

作業するディレクトリ (フォルダ) を作成し、対象バージョンの`docker-compose.yml`をダウンロード。
`docker-compose.yml`があるディレクトリ (フォルダ) で以下コマンドを実行。

```
$ docker-compose up -d
```

##### Kitematicで起動する場合

GUIで操作できるため手軽だが、ボリュームのマウント指定ができない。
そのため少なくとも現バージョンでは**起動に使用するのは非推奨**。

1. イメージから`ryublacknd`を検索し、`php`の「･･･」をクリック
1. 「SELECTED TAG:」でタグ (PHPのバージョン) を指定して「Ｘ」をクリック
1. 「CREATE」ボタンでコンテナ起動

## 使い方

LinuxやDocker for Windows / Macでは、localhostでアクセスできる。  

> Docker Toolboxでは割り当てられたIPアドレスを指定する必要がある。

```
http://localhost
```

phpMyAdminには`/phpmyadmin`でアクセスできる。
rootユーザーの初期パスワードは`password`。

PHPスクリプトは、ホスト側にマウントされた`html`ディレクトリ (フォルダ) にファイルを置けば動作する。ここをIDEやエディタのプロジェクトに登録すると便利。

[composer](https://getcomposer.org/)を使用するフレームワーク等は、`docker exec`でコンテナ内に入って操作するのが基本。

```
$ docker exec -it php70 bash
```

[Kitematic](https://kitematic.com/)を使っているなら、起動中のコンテナで "EXEC" アイコンをクリックすれば、上記と同じ状態でPowershellが起動する。

ローカルでcomposerを実行できるのであればそちらを使っても良い。

## その他

開発用メールサーバは、実際にはメールを送信しない[MailCatcher](https://mailcatcher.me/)がお勧め。
