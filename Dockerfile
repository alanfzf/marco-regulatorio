# DOCS:
# https://laravel-news.com/multi-stage-docker-builds-for-laravel
# https://github.com/Avnsh1111/laravel-docker-with-php8.2-apache-mysql

# ==================
# VENDOR STAGE
# ==================
FROM composer:lts AS vendor

WORKDIR /composer
# this time we need to copy everything as we need all files to execute composer correctly
COPY . .

RUN composer install \
        --ignore-platform-reqs \
        --no-ansi \
        --no-dev \
        --no-interaction \
        --no-progress \
        --prefer-dist \
        --optimize-autoloader

# ==================
# NODE MODULES STAGE
# ==================
FROM node:lts-alpine AS node

WORKDIR /node
COPY . .
RUN yarn install && yarn build

# ==================
# FINAL IMAGE
# ==================
FROM php:8.2-apache AS production

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
WORKDIR /var/www/html/

# Copy app source code
COPY . .
# Copy vendor files
COPY --from=vendor /composer/vendor/ /var/www/html/vendor
# Copy node files
COPY --from=node /node/public/build /var/www/html/public/build
# Copy php ini dir
COPY ./etc/php.ini "$PHP_INI_DIR/conf.d/99-finanssoreal.ini"
# Copy apache config
COPY ./etc/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Install dependencies
RUN apt-get update && apt-get install -y \
      curl zip unzip \
      # unicode font stuff
      libicu-dev libfreetype6-dev \
      # image stuff
      libjpeg-dev libpng-dev \
      # compression
      libzip-dev zlib1g-dev \
      # xml
      libxml2-dev \
      # libonig: regex, libssldev (curl) libcurl4-openssl-dev
      libonig-dev libssl-dev

# configure intl
RUN docker-php-ext-configure intl && \
    # configure ftp
    docker-php-ext-configure ftp --with-openssl-dir=/usr && \
    # configure gd
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    # install base packages
    docker-php-ext-install -j$(nproc) \
      zip mysqli soap pdo_mysql mbstring exif pcntl bcmath gd xml intl ftp

# Do final cleanup
RUN apt-get -y autoremove && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# We need to give permissions to these directories
RUN chown -R www-data:www-data storage bootstrap/cache

# Setup apache server
RUN a2enmod rewrite
EXPOSE 80

CMD ["apache2-foreground"]
