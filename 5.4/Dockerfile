FROM centos:6

RUN sed -i '/^ZONE/d' /etc/sysconfig/clock
RUN sed -i '/^UTC/d' /etc/sysconfig/clock
RUN echo 'ZONE="Asia/Tokyo"' >> /etc/sysconfig/clock
RUN echo 'UTC="false"' >> /etc/sysconfig/clock
RUN cp -p /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

RUN yum -y install epel-release
RUN rpm -ivh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
RUN yum -y update --enablerepo=remi

RUN yum -y groupinstall "Japanese Support"
RUN localedef -f UTF-8 -i ja_JP ja_JP.utf8
RUN echo 'LANG="ja_JP.UTF-8"' > /etc/sysconfig/i18n

RUN yum -y install --enablerepo=remi \
    curl \
    freetype-devel \
    gd-last \
    git \
    httpd \
    httpd-devel \
    ImageMagick-devel \
    libmcrypt \
    mysql-server \
    openssl-devel \
    supervisor \
    vim \
    wget \
    php54-php \
    php54-php-cli \
    php54-php-devel \
    php54-php-gd \
    php54-php-mbstring \
    php54-php-mcrypt \
    php54-php-mysqlnd \
    php54-php-pear \
    php54-php-pecl-imagick \
    php54-php-pecl-xdebug \
    php54-php-pdo \
    php54-php-xml \
    php54-php-tidy \
    php54-php-bcmath \
    gettext

WORKDIR /var/www/html
RUN wget https://github.com/phpmyadmin/phpmyadmin/archive/RELEASE_4_4_15_10.tar.gz
RUN tar zxf RELEASE_4_4_15_10.tar.gz
RUN rm -f RELEASE_4_4_15_10.tar.gz
RUN mv phpmyadmin-RELEASE_4_4_15_10 phpmyadmin
WORKDIR /var/www/html/phpmyadmin
RUN scripts/generate-mo

RUN sed -i -e "s|^;date.timezone =.*$|date.timezone = Asia/Tokyo|" /etc/php.ini
RUN sed -i -e "s|^upload_max_filesize =.*$|upload_max_filesize = 64M|" /etc/php.ini
RUN sed -i -e "s|^post_max_size =.*$|post_max_size = 64M|" /etc/php.ini

RUN sed -i -e "s|Allow from 127.0.0.1$|Allow from All|g" /etc/httpd/conf.d/phpMyAdmin.conf

RUN rm -f /etc/httpd/conf.d/welcome.conf
RUN rm -f /var/www/error/noindex.html

COPY virtual.conf /etc/httpd/conf.d/virtual.conf
COPY my.cnf /etc/my.cnf
COPY config.inc.php /var/www/html/phpmyadmin/config.inc.php
COPY supervisord.conf /etc/supervisord.conf

RUN /etc/init.d/mysqld start \
 && mysqladmin -u root password 'password'

WORKDIR /var/www/html

CMD ["/usr/bin/supervisord"]
