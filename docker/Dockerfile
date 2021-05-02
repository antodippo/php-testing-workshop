FROM php:8.0-apache

COPY . /var/www/coins
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN pecl channel-update pecl.php.net
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN apt-get update
RUN apt-get install -y libzip-dev zip libonig-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN chown -R www-data:www-data /var/www/coins
RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN service apache2 restart

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_CACHE_DIR=/root/.composer/cache
