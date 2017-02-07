FROM centos:6

RUN sed -i '/^ZONE/d' /etc/sysconfig/clock
RUN sed -i '/^UTC/d' /etc/sysconfig/clock
RUN echo 'ZONE="Asia/Tokyo"' >> /etc/sysconfig/clock
RUN echo 'UTC="false"' >> /etc/sysconfig/clock
RUN cp -p /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

RUN rpm -ivh http://dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm
RUN rpm -ivh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm

RUN yum -y update
RUN yum -y groupinstall "Japanese Support"
RUN localedef -f UTF-8 -i ja_JP ja_JP.utf8
RUN echo 'LANG="ja_JP.UTF-8"' > /etc/sysconfig/i18n

RUN yum -y install  curl \
                    freetype-devel \
                    git \
                    httpd \
                    httpd-devel \
                    libmcrypt \
                    mysql-server \
                    supervisor \
                    vim \
                    wget
RUN yum -y install --enablerepo=epel,remi-php56,remi \
                    php \
                    php-cli \
                    php-devel \
                    php-gd \
                    php-imagick \
                    php-mbstring \
                    php-mcrypt \
                    php-mysqlnd \
                    php-pear \
                    php-phpunit-PHPUnit \
                    php-pdo \
                    php-xml \
                    php-xdebug \
                    php-memcached \
                    phpMyAdmin
RUN sed -i -e "s|^;date.timezone =.*$|date.timezone = Asia/Tokyo|" /etc/php.ini

RUN rm -f /etc/httpd/conf.d/welcome.conf
RUN rm -f /var/www/error/noindex.html

COPY virtual.conf /etc/httpd/conf.d/virtual.conf
COPY my.cnf /etc/my.cnf
COPY supervisord.conf /etc/supervisord.conf

WORKDIR /var/www/html

EXPOSE 80
EXPOSE 443

CMD ["/usr/bin/supervisord"]
