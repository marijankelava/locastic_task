FROM php:7.4-apache

WORKDIR /var/www

RUN apt-get update && apt-get install -y bash-completion libzip-dev libjpeg62 libpng-dev libxrender-dev libfontconfig1 libxext-dev zlib1g-dev libicu-dev g++ unzip cron

RUN a2enmod rewrite headers
RUN service apache2 restart

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install gd

RUN echo 'memory_limit = 2G' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;
RUN echo 'date.timezone = CET' >> /usr/local/etc/php/conf.d/docker-php-date.ini;

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer