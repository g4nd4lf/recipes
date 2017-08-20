FROM httpd:2.4-alpine

RUN apk --no-cache add nano bash openssl

COPY ./provisioning/http/config/httpd.conf /usr/local/apache2/conf/httpd.conf
COPY ./provisioning/http/config/site.conf /usr/local/apache2/vhosts/site.conf

COPY ./web /var/www/html/web

RUN mkdir -p /usr/local/apache2/ssl/certs \
  && openssl req -new -newkey rsa:4096 -days 3650 -nodes -x509 \
    -subj "/C=UK/ST=East Yorkshire/L=York/CN=*.recipes.co.uk" \
    -keyout /usr/local/apache2/ssl/certs/app.key -out /usr/local/apache2/ssl/certs/app.crt
