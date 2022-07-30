FROM php:8.1-cli-alpine

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock /usr/src/app/

WORKDIR /usr/src/app

RUN composer install

COPY . .

RUN composer dump-autoload -o