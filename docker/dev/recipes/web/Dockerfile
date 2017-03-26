FROM ubuntu:16.04
MAINTAINER Mark Taylor <mark@cod3r.co.uk>

RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections
RUN apt-get update && apt-get -y install curl
RUN curl -s http://deb.nodesource.com/gpgkey/nodesource.gpg.key | apt-key add - && \
rm -rf /var/lib/apt/lists/*

RUN echo 'deb http://archive.ubuntu.com/ubuntu xenial multiverse\n \
deb http://archive.ubuntu.com/ubuntu xenial-updates multiverse\n \
deb http://security.ubuntu.com/ubuntu xenial-security multiverse\n \
deb http://deb.nodesource.com/node_7.x xenial main\n \
deb-src http://deb.nodesource.com/node_7.x xenial main\n' \
>> /etc/apt/sources.list

RUN apt-get update && \
apt-get -y install --no-install-recommends \
apache2 \
libapache2-mod-fastcgi \
php-fpm \
php-intl \
php-mysql \
php-gd \
php-xdebug \
php-curl \
nano \
acl \
nodejs \
mysql-client \
git \
build-essential \
golang-go \
sudo \
openssh-client \
ssl-cert && \
rm -rf /var/lib/apt/lists/*

# mhsendmail handles forwarding mail to fake dev SMTP server (mailhog)
RUN mkdir /opt/go && export GOPATH=/opt/go && go get github.com/mailhog/mhsendmail

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin
RUN mv /usr/local/bin/composer.phar /usr/local/bin/composer

# setup a default system user and password
RUN groupadd -g 1000 app && \
useradd -d /home/app -m app --uid 1000 --gid 1000 && \
adduser app sudo && \
echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

EXPOSE 80
EXPOSE 443

ADD config/php/php-fpm.conf /etc/apache2/conf-available/php7.0-fpm.conf
ADD config/php/php_apache.ini /etc/php/7.0/fpm/php.ini
ADD config/php/php_cli.ini /etc/php/7.0/cli/php.ini

RUN a2enmod rewrite ssl
RUN a2enmod actions fastcgi alias
RUN a2enconf php7.0-fpm

RUN echo "listen.mode = 0660" >> /etc/php/7.0/fpm/pool.d/www.conf

ADD entrypoint.sh /opt/bin/entrypoint.sh
RUN chmod u=rwx /opt/bin/entrypoint.sh

ADD config/virtualhost/default.conf /etc/apache2/sites-enabled/000-default.conf
ADD config/virtualhost/default-ssl.conf /etc/apache2/sites-enabled/default-ssl.conf

WORKDIR /app

ENTRYPOINT ["/opt/bin/entrypoint.sh"]
