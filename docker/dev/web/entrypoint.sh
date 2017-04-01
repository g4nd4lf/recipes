#!/bin/bash

service php7.0-fpm start
source /etc/apache2/envvars && exec /usr/sbin/apache2 -DFOREGROUND

