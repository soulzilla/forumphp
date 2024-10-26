# Download official image of php with extansions
ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm-alpine

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apk update && apk add \
  oniguruma-dev \
  libxml2-dev \
  libpng-dev \
  libjpeg-turbo-dev \
  libzip-dev \
  unzip \
  zip \
  git \
  curl \
  libwebp-dev

RUN apk --no-cache add --virtual .build-deps $PHPIZE_DEPS

# Install xdebug
ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    apk update && apk add linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
;fi

# Install composer
ARG INSTALL_COMPOSER=false

RUN if [ ${INSTALL_COMPOSER} = true ]; then \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
;fi

# Install extensions

RUN docker-php-ext-configure gd --with-jpeg --with-webp
RUN docker-php-ext-install pdo_mysql gd zip exif pcntl

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    docker-php-ext-enable xdebug \
;fi

###########################################################################
# ImageMagick:
###########################################################################

USER root

ARG INSTALL_IMAGEMAGICK=false
ARG IMAGEMAGICK_VERSION=latest
ENV IMAGEMAGICK_VERSION ${IMAGEMAGICK_VERSION}

RUN if [ ${INSTALL_IMAGEMAGICK} = true ]; then \
    apk --no-cache add \
    libmagickwand-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
;fi

###########################################################################
# PHP REDIS EXTENSION
###########################################################################

ARG INSTALL_PHPREDIS=false

RUN if [ ${INSTALL_PHPREDIS} = true ]; then \
    apk --no-cache add \
    redis \
    && apk --no-cache add --virtual .build-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
;fi

ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# Add user for laravel application
RUN addgroup -g ${PGID} www
RUN adduser --disabled-password -H -u ${PUID} -s /bin/bash -G www www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
ARG NGINX_PHP_UPSTREAM_PORT=9000

EXPOSE ${NGINX_PHP_UPSTREAM_PORT}
CMD ["php-fpm"]