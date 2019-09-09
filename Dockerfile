FROM php:7.2-apache
COPY . /var/www/html/
# you might care about copy because even though you're mounting a drive in development, you may not want to in production since the code won't change?
WORKDIR /var/www/html/
RUN apt-get update && apt-get install -y
CMD /usr/sbin/apache2ctl -D FOREGROUND