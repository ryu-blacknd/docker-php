FROM centos:6

MAINTAINER Ryuichi Sano

RUN yum -y update \
 && yum -y install epel-release \
 && rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm \
 && rpm -Uvh http://dev.mysql.com/get/mysql-community-release-el6-5.noarch.rpm \
 && yum -y install \
    wget \
    gcc \
    expect \
    pcre-devel \
    openssl-devel \
    libxml2-devel \
    libcurl-devel \
    libvpx-devel \
    libjpeg-devel \
    libpng-devel \
    freetype-devel \
    libc-client-devel \
    libmcrypt-devel \
    ImageMagick-devel \
    re2c \
    mysql-community-server \
    postfix \
 && yum clean all \
 && echo "127.0.0.1 develop.local" >> /etc/hosts

WORKDIR /tmp/src

# Apache
RUN wget http://ftp.tsukuba.wide.ad.jp/software/apache//apr/apr-1.5.2.tar.gz \
 && tar zxf apr-1.5.2.tar.gz \
 && cd apr-1.5.2 \
 && ./configure \
 && make \
 && make install

RUN wget http://ftp.yz.yamagata-u.ac.jp/pub/network/apache//apr/apr-util-1.5.4.tar.gz \
 && tar zxf apr-util-1.5.4.tar.gz \
 && cd apr-util-1.5.4 \
 && ./configure \
    --with-apr=/usr/local/apr \
 && make \
 && make install

RUN wget http://ftp.yz.yamagata-u.ac.jp/pub/network/apache//httpd/httpd-2.4.20.tar.gz \
 && tar zxf httpd-2.4.20.tar.gz \
 && cd httpd-2.4.20 \
 && ./configure \
     --enable-so \
     --enable-rewrite \
     --enable-ssl \
     --enable-mods-shared=all \
 && make \
 && make install

RUN groupadd apache \
 && useradd -g apache apache \
 && mkdir -p /var/www/html \
 && chown -R apache:apache /var/www \
 && sed -i \
    -e 's~#LoadModule socache_shmcb_module modules/mod_socache_shmcb.so~LoadModule socache_shmcb_module modules/mod_socache_shmcb.so~g' \
    -e 's~#LoadModule ssl_module modules/mod_ssl.so~LoadModule ssl_module modules/mod_ssl.so~g' \
    -e 's~#LoadModule rewrite_module modules/mod_rewrite.so~LoadModule rewrite_module modules/mod_rewrite.so~g' \
    -e 's~User daemon~User apache~g' \
    -e 's~Group daemon~Group apache~g' \
    -e 's~ServerAdmin you@example.com~ServerAdmin root@develop.local~g' \
    -e 's~#ServerName www.example.com:80~ServerName develop.local:80~g' \
    -e 's~DocumentRoot "/usr/local/apache2/htdocs"~DocumentRoot "/var/www/html"~g' \
    -e 's~<Directory "/usr/local/apache2/htdocs">~<Directory "/var/www/html">~g' \
    -e 's~AllowOverride None~AllowOverride All~g' \
    -e 's~#Include conf/extra/httpd-ssl.conf~Include conf/extra/httpd-ssl.conf~g' \
    /usr/local/apache2/conf/httpd.conf \
 && sed -i \
    -e 's~DocumentRoot "/usr/local/apache2/htdocs"~DocumentRoot "/var/www/html"~g' \
    -e 's~ServerName www.example.com:443~ServerName develop.local:443~g' \
    -e 's~ServerAdmin you@example.com~ServerAdmin root@develop.local~g' \
    /usr/local/apache2/conf/extra/httpd-ssl.conf

RUN cd /usr/local/apache2/conf \
 && openssl genrsa -out server.key 2048 \
 && openssl req -new -key server.key -out server.csr -subj '/C=JP/ST=Aichi/L=Nagoya/O=develop.local/OU=Web/CN=develop.local' \
 && openssl x509 -in server.csr -days 3650 -req -signkey server.key > server.crt

# PHP
RUN wget http://jp2.php.net/get/php-5.5.35.tar.gz/from/this/mirror -O php.tar.gz \
 && tar zxf php.tar.gz \
 && cd php-5.5.35 \
 && ./configure \
    --with-apxs2=/usr/local/apache2/bin/apxs \
    --enable-mbstring \
    --enable-pdo \
    --enable-zip \
    --with-gd \
    --with-vpx-dir=/usr \
    --with-jpeg-dir=/usr \
    --with-png-dir=/usr \
    --with-mysql=mysqlnd \
    --with-mysqli=mysqlnd \
    --with-pdo-mysql=mysqlnd \
    --with-curl \
    --with-openssl \
    --with-mcrypt \
    --with-zlib \
 && make \
 && make install \
 && cp php.ini-production /usr/local/lib/php.ini

RUN sed -i \
    -e 's~max_execution_time = 30~max_execution_time = 120~g' \
    -e 's~post_max_size = 8M~post_max_size = 64M~g' \
    -e 's~upload_max_filesize = 2M~upload_max_filesize = 64M~g' \
    -e 's~;date.timezone =~date.timezone = Asia/Tokyo~g' \
    -e 's~;mbstring.language = Japanese~mbstring.language = Japanese~g' \
    /usr/local/lib/php.ini

RUN expect -c "spawn pecl install imagick; expect \"Please provide the prefix of Imagemagick installation \[autodetect\] :\"; send \"\n\"; expect eof;" \
 && echo "extension=imagick.so" >> /usr/local/lib/php.ini \
 && curl -sS https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer \
 && echo "Include conf/extra/httpd-php5.conf" >> /usr/local/apache2/conf/httpd.conf

COPY httpd-php5.conf /usr/local/apache2/conf/extra/

# phpMyAdmin
RUN wget https://files.phpmyadmin.net/phpMyAdmin/4.6.1/phpMyAdmin-4.6.1-all-languages.tar.gz \
 && tar zxf phpMyAdmin-4.6.1-all-languages.tar.gz \
 && mv phpMyAdmin-4.6.1-all-languages /var/www/phpMyAdmin \
 && chown -R apache:apache /var/www/phpMyAdmin \
 && echo "Include conf/extra/httpd-phpMyAdmin.conf" >> /usr/local/apache2/conf/httpd.conf

COPY httpd-phpMyAdmin.conf /usr/local/apache2/conf/extra/
COPY config.inc.php /var/www/phpMyAdmin/

# MySQL
COPY my.cnf /etc/my.cnf

RUN chkconfig mysqld on \
 && service mysqld start \
 && mysqladmin -u root password 'password'

# Postfix
RUN postconf -e myhostname="mail.example.com" \
 && postconf -e mydomain="example.com" \
 && postconf -e myorigin='$mydomain' \
 && postconf -e inet_interfaces="localhost" \
 && postconf -e inet_protocols="ipv4" \
 && postconf -e mydestination='$myhostname, localhost.$mydomain, localhost, $mydomain' \
 && postconf -e mynetworks="172.17.0.0/16 127.0.0.0/8" \
 && echo "smtputf8_enable=no" >> /etc/postfix/main.cf

# for OP25B
#RUN postconf -e relayhost="smtp.server.com:587" \
# && postconf -e smtp_sasl_auth_enable="yes" \
# && postconf -e smtp_sasl_security_options="noanonymous" \
# && postconf -e smtp_sasl_mechanism_filter="PLAIN LOGIN CRAM-MD5" \
# && postconf -e smtp_sasl_password_maps="hash:/etc/postfix/authinfo" \
# && echo "smtp.server.com:587 user:pass" > /etc/postfix/authinfo \
# && postmap /etc/postfix/authinfo \
# && chmod 640 /etc/postfix/authinfo

RUN chkconfig postfix on \
 && service postfix start

###
RUN rm -rf /tmp/src

EXPOSE 80 443 25

VOLUME /var/www/html

WORKDIR /var/www/html

CMD ["/usr/local/apache2/bin/httpd", "-k", "start"]
