FROM php:8.2-fpm

WORKDIR /var/www/br

RUN apt-get update \
    && apt-get install -y \
        libpq-dev  \
        build-essential \
        locales \
        zip \
        unzip \
        git \
        curl\
    && docker-php-ext-install pdo pdo_mysql mysqli

RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

COPY ./entrypoint.sh /var/www/br/entrypoint.sh
RUN chmod +x /var/www/br/entrypoint.sh

ENTRYPOINT ["/var/www/br/entrypoint.sh"]

CMD ["php-fpm"]
