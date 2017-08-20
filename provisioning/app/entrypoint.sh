#!/bin/bash

# Set a nicer default prompt
echo "export PS1=\"\u@\h \w $ \"" | tee -a /root/.bashrc /home/app/.bashrc

RUN composer install --no-interaction --no-suggest --optimize-autoloader
chgrp -R cacherw /var/www/html/var

exec php-fpm
