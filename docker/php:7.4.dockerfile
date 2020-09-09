FROM php:7.4-cli
LABEL maintainer="Andreas Stocker <AStocker@anexia-it.com>"


# Install system applications and libraries
RUN apt-get update && \
    apt-get install -y \
        git \
        cron \
        curl \
        file \
        unzip \
        gettext \
        build-essential \
        libonig-dev \
        libpq-dev \
        libmcrypt-dev \
        libmcrypt4 \
        libcurl3-dev \
        libxml2-dev \
        libfreetype6 \
        libjpeg62-turbo \
        libpng-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*


# Install composer
RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --filename=composer


# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql && \
    docker-php-ext-install gd && \
    docker-php-ext-install mbstring && \
    docker-php-ext-install soap && \
    docker-php-ext-install mysqli


# Install PECL modules
RUN pecl install xdebug && \
    echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /usr/local/etc/php/conf.d/10-xdebug.ini
