FROM php:7.2-apache

RUN apt-get update

RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    g++ \
    libxml2-dev \
    libldb-dev \
    libldap2-dev \
    libssl-dev \
    libxslt-dev \
    libpq-dev \
    libc-client-dev \
    libkrb5-dev \
    libmcrypt-dev \
    libpng-dev \
    libcurl4-gnutls-dev

RUN a2enmod rewrite headers

RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    mbstring \
    pdo_mysql \
    zip \
    simplexml \
    xml \
    xmlrpc \
    xmlwriter \
    wddx \
    xsl \
    soap \
    dom \
    session \
    json \
    hash \
    sockets \
    pdo \
    tokenizer \
    pgsql \
    pdo_pgsql \
    mysqli \
    curl \
    exif \
    fileinfo \
    gettext \
    pcntl \
    phar \
    posix

RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

#RUN apt install -y libgmp-dev # idk
#RUN docker-php-ext-install gmp # idk
#RUN docker-php-ext-install oci8 # idk
#RUN docker-php-ext-install odbc # idk
#RUN apt install -y freetds-dev # idk
#RUN docker-php-ext-install pdo_dblib  # idk
#RUN docker-php-ext-install pdo_oci # idk
#RUN docker-php-ext-install pdo_odbc # idk
#RUN apt install -y libreadline-dev # idk
#RUN docker-php-ext-install readline # idk
#RUN apt install -y libxml2-dev # idk
#RUN docker-php-ext-install xmlreader # idk
# idk bz2 enchant
