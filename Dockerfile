FROM php:8.2-fpm

RUN apt-get -y update

RUN apt-get install -y \
    # gnupg \
    # g++ \
    # procps \
    # openssl \
    # git \
    unzip \
    # zlib1g-dev \
    libzip-dev \
    # libfreetype6-dev \
    # libpng-dev \
    # libjpeg-dev \
    libicu-dev
    # libonig-dev \
    # libxslt1-dev \
    # acl \
    # npm
    # && echo 'alias sf="php bin/console"' >> ~/.bashrc
    # && apt-get clean && rm -rf /var/lib/apt/lists/*



RUN docker-php-ext-install pdo pdo_mysql zip intl
#opcache exif mbstring xsl gd

RUN docker-php-ext-configure intl


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer


COPY . .