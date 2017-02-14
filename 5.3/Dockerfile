FROM centos:6

RUN yum -y install epel-release
RUN rpm -ivh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
RUN yum -y update

RUN yum -y groupinstall "Japanese Support"
RUN localedef -f UTF-8 -i ja_JP ja_JP.utf8
RUN echo 'LANG="ja_JP.UTF-8"' > /etc/sysconfig/i18n

RUN yum -y install \
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
    php \
    php-cli \
    php-devel \
    php-gd \
    php-mbstring \
    php-mcrypt \
    php-mysqlnd \
    php-pear \
    php-pecl-imagick \
    php-pecl-xdebug \
    php-phpunit-PHPUnit \
    php-pdo \
    php-xml \
    composer \
    phpMyAdmin

RUN /etc/init.d/mysqld start \
 && mysqladmin -u root password 'password'

RUN sed -i -e "s|^;date.timezone =.*$|date.timezone = Asia/Tokyo|" /etc/php.ini
RUN sed -i -e "s|^upload_max_filesize =.*$|upload_max_filesize = 64M|" /etc/php.ini
RUN sed -i -e "s|^post_max_size =.*$|post_max_size = 64M|" /etc/php.ini

RUN sed -i -e "s|^pdo_mysql.default_socket=.*$|pdo_mysql.default_socket = /tmp/mysql.sock|" /etc/php.ini
RUN sed -i -e "s|^mysqli.default_socket =.*$|mysqli.default_socket = /tmp/mysql.sock|" /etc/php.ini

RUN sed -i -e "s|Allow from 127.0.0.1$|Allow from All|g" /etc/httpd/conf.d/phpMyAdmin.conf

RUN rm -f /etc/httpd/conf.d/welcome.conf
RUN rm -f /var/www/error/noindex.html

COPY virtual.conf /etc/httpd/conf.d/virtual.conf
COPY my.cnf /etc/my.cnf
COPY supervisord.conf /etc/supervisord.conf

WORKDIR /var/www/html

CMD ["/usr/bin/supervisord"]
