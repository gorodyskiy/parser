FROM php:8.3-fpm-alpine

ARG TZ=UTC
ARG user=app
ARG uid=1000

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apk update \
    && apk add --no-cache curl icu-dev zip postgresql-dev unzip bash libzip-dev libpng libpng-dev jpeg jpeg-dev git libmemcached libmemcached-dev freetype freetype-dev $PHPIZE_DEPS

RUN set -eux \
    && pecl install memcached redis \
    && docker-php-ext-enable memcached redis \
    && true

RUN docker-php-ext-configure gd \
    --with-freetype

RUN  docker-php-ext-configure intl \
    && docker-php-ext-install bcmath exif gd intl mysqli opcache pcntl pdo_mysql pdo_pgsql zip

RUN rm -rf /tmp/* /var/tmp/* \
    && docker-php-source delete

RUN adduser -G "www-data" -u $uid -D -h /home/$user $user

RUN mkdir -p /home/$user/.composer && \
    chown -R $uid:$uid /home/$user

COPY ./conf/php.ini /usr/local/etc/php/php.ini
COPY start.sh /usr/local/bin/start

RUN chmod 777 /usr/local/bin/start

WORKDIR /var/www

USER $user

CMD ["/usr/local/bin/start"]
