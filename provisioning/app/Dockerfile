FROM mbtaylor78/php7-composer

RUN addgroup cacherw \
 && adduser www-data cacherw \
 && adduser app cacherw

RUN mkdir -m 0774 /var/www/html/var && chgrp -R cacherw /var/www/html/var

# Copy Project Dependencies
COPY composer.* /var/www/html/

RUN composer install --no-autoloader ${COMPOSER_FLAGS}

COPY ./app /var/www/html/app
COPY ./bin /var/www/html/bin
COPY ./src /var/www/html/src
COPY ./web /var/www/html/web
COPY ./provisioning/app/config/php.ini /usr/local/etc/php/php.ini

COPY ./provisioning/app/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]
