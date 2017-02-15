# 日本語PHP+DB開発環境 - バージョン別

[![Build Status](https://travis-ci.org/ryu-blacknd/docker-php.svg?branch=master)](https://travis-ci.org/ryu-blacknd/docker-php)

PHP+DB開発者用のDockerイメージ。  
すぐにPHP+DB開発を開始できる状態で起動する。  
LAMP環境に加え、開発用疑似メールサーバ、日本語フォント等をインストール済み。  
動作検証用に公式サポートの終了したバージョンも揃えてある。

https://hub.docker.com/r/ryublacknd/php/

## 概要

* CentOS 6
* Apache 2.2
* PHP（Tag: [5.3](https://github.com/ryu-blacknd/docker-php/tree/master/5.3), [5.4](https://github.com/ryu-blacknd/docker-php/tree/master/5.4), [5.5](https://github.com/ryu-blacknd/docker-php/tree/master/5.5), [5.6](https://github.com/ryu-blacknd/docker-php/tree/master/5.6), [7.0](https://github.com/ryu-blacknd/docker-php/tree/master/7.0),  [7.1](https://github.com/ryu-blacknd/docker-php/tree/master/7.1), [latest](https://github.com/ryu-blacknd/docker-php/tree/master/7.1)）
* MySQL 5.1 / 5.5 (PHP 5.3環境ではMySQL 5.1)
* phpMyAdmin 4
* GD, ImageMagick 6
* Ruby 2.3.3
* Mailcatcher
* 日本語フォント (IPAゴシック、IPA明朝、VLゴシック)
* その他 (git, vim, curl, wget, freetype, composer等)

## 起動方法

#### dockerコマンドで起動する場合

作業するディレクトリ (フォルダ) を作成し、その中で以下のコマンドを実行。

```
$ docker run -d -v ./html:/var/www/html -v ./mysql_data:/var/lib/mysql -p 80:80 -p 443:443 ryublacknd/php:7.0
```

#### docker-composeコマンドで起動する場合

作業するディレクトリ (フォルダ) を作成し、対象バージョンの`docker-compose.yml`をダウンロード。
`docker-compose.yml`があるディレクトリ (フォルダ) で以下のコマンドを実行。

```
$ docker-compose up -d
```

#### Kitematicで起動する場合

GUIで操作できるため手軽だが、ボリュームのマウント指定ができない。  
そのため少なくとも現バージョンでは**起動に使用するのは非推奨**。

1. イメージから`ryublacknd`を検索し、`php`の「･･･」をクリック
1. 「SELECTED TAG:」でタグ (PHPのバージョン) を指定して「Ｘ」をクリック
1. 「CREATE」ボタンでコンテナ起動

## PHP+DB開発について

LinuxやDocker for Windows / Macでは、localhostでアクセスできる。  

> Docker Toolboxでは割り当てられたIPアドレスを指定する必要がある。

```
http://localhost
```

phpMyAdminには以下でアクセスできる。rootユーザーの初期パスワードは`password`。

```
http://localhost/phpmyadmin
```

PHPスクリプトは、ホスト側にマウントされた`html`ディレクトリ (フォルダ) にファイルを置けば動作する。  
ここをIDEやエディタのプロジェクトに登録すると便利。

[composer](https://getcomposer.org/)を使用するフレームワーク等は、`docker exec`でコンテナ内に入って操作するのが基本。

```
$ docker exec -it php70 bash
```

[Kitematic](https://kitematic.com/)を使っているなら、起動中のコンテナで「EXEC」をクリックすれば、上記と同じ状態でPowershellが起動する。

ローカルでcomposerを実行できるのであればそちらを使っても良い。

## 開発用メールサーバについて

[MailCatcher](https://mailcatcher.me/)が疑似SMTPサーバとして動作する。PHPのSendmail代替としても設定済み。  
MailCatcherが受け取ったメールは、実際に送信はせずデータとして蓄積され、Webメールインターフェースで確認できる。

Webメールインターフェースには、以下でアクセスできる。

```
http://localhost:1080
```

MailCatcherのSMTPが使用するポートは1025がデフォルトだが、開発環境内では通常のSMTPサーバと同じ25を割り当ててある。

* 25：SMTPサーバ
* 1080：Webメールインターフェース

## その他

ポート80や443が使用中で割り当てられないとエラーが出る場合、これらのポートを使用しているアプリケーションを探して停止するか、どちらかの割り当てポートを変更する。  
例えばSkypeには詳細設定でポート80や443を使うオプションがあり、かなり怪しい。
