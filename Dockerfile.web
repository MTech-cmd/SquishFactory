FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y zip unzip curl \
    && docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/

COPY composer.* .

RUN composer install --no-interaction --no-dev --optimize-autoloader

COPY . .

CMD ["apache2-foreground"]
