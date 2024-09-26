FROM php:8.3-fpm-alpine

# Install dependencies
RUN set -ex \
    && apk --no-cache add postgresql-dev yarn\
    && docker-php-ext-install pdo pdo_pgsql exif


# Install PHP extensions \
RUN docker-php-ext-install pdo pdo_pgsql exif \
    && curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o - | sh -s \
        gd xdebug exif

# Install Composer \
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html
