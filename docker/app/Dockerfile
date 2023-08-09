FROM centos:7
RUN yum -y update && yum install -y iproute iproute-doc git make httpd https://rpms.remirepo.net/enterprise/remi-release-7.rpm yum-utils && yum-config-manager --enable remi-php81 && yum install -y php \
 && yum install -y pwgen php php-cli php-zip php-soap wget unzip gcc php-pear php-xdebug php-devel mysql-devel php-common php-opcache php-mcrypt php-cli php-gd php-curl php-mysql \
 && yum install -y php-common php-opcache php-mcrypt php-cli php-gd php-curl php-mysql php-xml php-simplexml php-mbstring \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
 && touch /etc/php.d/xdebug.log \
 && chmod 777 /etc/php.d/xdebug.log \
 && echo "[XDEBUG]" > /etc/php.d/15-xdebug.ini \ 
 && echo "zend_extension=xdebug.so" > /etc/php.d/15-xdebug.ini \ 
 && echo 'xdebug.mode=debug' >> /etc/php.d/15-xdebug.ini \
 && echo 'xdebug.start_with_request=yes' >> /etc/php.d/15-xdebug.ini \
 && echo 'xdebug.show_error_trace = 1' >> /etc/php.d/15-xdebug.ini \
 && echo 'xdebug.discover_client_host=1' >> /etc/php.d/15-xdebug.ini \
 && echo 'xdebug.remote_autostart=1' >> /etc/php.d/15-xdebug.ini \
 && echo 'xdebug.remote_connect_back=0' >> /etc/php.d/15-xdebug.ini \
 && echo 'xdebug.remote_cookie_expire_time = 3600' >> /etc/php.d/15-xdebug.ini \
 && echo 'xdebug.remote_handler=dbgp' >> /etc/php.d/15-xdebug.ini \ 
 && echo 'xdebug.client_port=9086' >> /etc/php.d/15-xdebug.ini \
 && echo 'xdebug.client_host=host.docker.internal' >> /etc/php.d/15-xdebug.ini \
 && echo 'xdebug.idekey=VSCODE' >> /etc/php.d/15-xdebug.ini \
 && echo 'xdebug.log=/etc/php.d/xdebug.log' >> /etc/php.d/15-xdebug.ini

# Configs httpd
CMD mkdir /etc/httpd/sites-available
CMD mkdir /etc/httpd/sites-enabled
COPY httpd.conf /etc/httpd/conf/
COPY 000-default.conf /etc/httpd/sites-available/
COPY 000-default.conf /etc/httpd/sites-enabled/ 
 

WORKDIR /var/www/html/

EXPOSE 80
EXPOSE 443
EXPOSE 9086


CMD ["/usr/sbin/httpd", "-D", "FOREGROUND"]