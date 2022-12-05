FROM php:8.1-fpm
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
    && apt-get update \
    && apt-get install -y git unzip symfony-cli libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash

WORKDIR /app
COPY . .

RUN composer install -n

RUN symfony server:ca:install

EXPOSE 8000

CMD php bin/console doctrine:migrations:migrate -n && symfony serve