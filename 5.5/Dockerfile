FROM centos:6

MAINTAINER Ryuichi Sano

RUN yum -y install epel-release \
 && rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm \
 && rpm -Uvh http://dev.mysql.com/get/mysql-community-release-el6-5.noarch.rpm \
 && yum -y install \
    wget \
    pcre-devel \
    libxml2-devel \
    openssl-devel \
    ImageMagick-devel \
    mysql-community-server \
    postfix \
 && yum clean all

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
 && ./configure --width-apr=/usr/local/apr \
 && make \
 && make install

RUN wget http://ftp.yz.yamagata-u.ac.jp/pub/network/apache//httpd/httpd-2.4.20.tar.gz \
 && tar zxf httpd-2.4.20.tar.gz \
 && cd httpd-2.4.20 \
 && ./configure \
     --enable-so \
     --enable-shared \
     --enable-ssl \
     --enable-rewrite \
 && make \
 && make install

RUN sed -i \
   -e 's~ServerAdmin root@localhost~ServerAdmin root@develop.local~g' \
   -e 's~#ServerName www.example.com:80~ServerName develop.local:80~g' \
   -e 's~AllowOverride None~AllowOverride All~g' \
   /usr/local/apache2/conf/httpd.conf \
&& sed -i \
   -e 's~#DocumentRoot "/var/www/html"~DocumentRoot "/var/www/html"~g' \
   -e 's~#ServerName www.example.com:443~ServerName develop.local:443~g' \
   /usr/local/apache2/conf.d/ssl.conf

# PHP
RUN sed -i \
    -e 's~max_execution_time = 30~max_execution_time = 120~g' \
    -e 's~post_max_size = 8M~post_max_size = 64M~g' \
    -e 's~upload_max_filesize = 2M~upload_max_filesize = 64M~g' \
    -e 's~;date.timezone =~date.timezone = Asia/Tokyo~g' \
    -e 's~;mbstring.language = Japanese~mbstring.language = Japanese~g' \
    /etc/php.ini \
 && curl -sS https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer

# MySQL
COPY my.cnf /etc/my.cnf

RUN checkconfig mysqld on \
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
 && echo "smtputf8_enable=no" >> /etc/postfix/main.cf \
 && systemctl enable postfix \
 && systemctl start postfix

# for OP25B
#RUN postconf -e relayhost="smtp.server.com:587" \
# && postconf -e smtp_sasl_auth_enable="yes" \
# && postconf -e smtp_sasl_security_options="noanonymous" \
# && postconf -e smtp_sasl_mechanism_filter="PLAIN LOGIN CRAM-MD5" \
# && postconf -e smtp_sasl_password_maps="hash:/etc/postfix/authinfo" \
# && echo "smtp.server.com:587 user:pass" > /etc/postfix/authinfo \
# && postmap /etc/postfix/authinfo \
# && chmod 640 /etc/postfix/authinfo

# phpMyAdmin
RUN mv /etc/httpd/conf.d/phpMyAdmin.conf /etc/httpd/conf.d/phpMyAdmin.conf.default
COPY phpMyAdmin.conf /etc/httpd/conf.d/
COPY config.inc.php /usr/share/phpMyAdmin/

EXPOSE 80 443 25

VOLUME /var/www/html

WORKDIR /var/www/html

CMD ["systemctl", "start", "httpd"]
