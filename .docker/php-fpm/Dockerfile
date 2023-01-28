FROM php:8.2.0-fpm-alpine

# Install packages
RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash --update linux-headers

# Xdebug
ARG INSTALL_XDEBUG=false

#RUN if [ ${INSTALL_XDEBUG} = true ]; \
#    then \

RUN pecl install xdebug && docker-php-ext-enable xdebug
#    fi;

RUN apk update; \
    apk -y --no-install-recommends install \
        php8.2-bcmath \
        php8.2-mysql \

    apk clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY ./php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini

# Postgres
RUN apk add --no-cache libpq-dev && docker-php-ext-install pdo_mysql

# Configure non-root user.
ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Source code
RUN chown www-data:www-data /var/www
COPY --chown=www-data:www-data ./ /var/www
WORKDIR /var/www

# Composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#RUN composer install --no-interaction
USER www-data

CMD php-fpm

EXPOSE 9000