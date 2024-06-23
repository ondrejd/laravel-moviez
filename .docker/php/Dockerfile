FROM php:8.3-fpm-alpine

ARG user
ARG uid

#
# Instalace zavislosti
#

RUN apk add --update --no-cache \
    libzip \
    libpq \
    nano \
    musl-locales \
    memcached \
    libmemcached \
    postgresql-client \
    freetype \
    libpng \
    libjpeg-turbo \
    tzdata \
    libcurl \
    libssh2 \
    libintl \
    ca-certificates \
    libtool \
    nodejs \
    npm \
    nginx \
    libwebp \
    libldap \
    py-pip \
    icu \
    && ln -fs /usr/share/zoneinfo/${TIMEZONE} /etc/localtime

#
# PHP
#

RUN apk add --no-cache --virtual .build-dependencies \
    $PHPIZE_DEPS \
    freetype-dev \
    icu-dev \
    libzip-dev \
    libmemcached-dev \
    libxml2-dev \
    libssh2-dev \
    libxslt-dev \
    libpq-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    ldb-dev \
    openldap-dev \
    linux-headers \
    && docker-php-ext-configure bcmath --enable-bcmath \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install intl \
    && docker-php-ext-install ldap \
    && docker-php-ext-enable ldap \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && composer self-update \
    && docker-php-source delete \
    && rm -rf /tmp/* /var/cache/apk/* \
    && apk del .build-dependencies

#
# Lokalizace
#

ENV TERM=xterm \
    LANG=cs_CZ.UTF-8 \
    LANGUAGE=cs_CZ.UTF-8 \
    LC_CTYPE=cs_CZ.UTF-8 \
    LC_ALL=cs_CZ.UTF-8

#
# Nastaveni
#

RUN addgroup $user && \
    adduser -S -u 1000 -G www-data -G $user -h /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

#
# Ostatni
#

WORKDIR /var/www

USER $user
