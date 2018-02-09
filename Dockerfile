FROM wordpress
ADD ./uploads.ini /usr/local/etc/php/conf.d/uploads.ini
ADD ./themes /var/www/html/wp-content/themes
