FROM php:8.3-cli-alpine

RUN apk update && \
    apk add --no-cache \
        git \
        ruby \
        ruby-dev \
        build-base \
        zlib-dev \
        libtool \
        make \
        gcc \
        bash \
        autoconf \
        linux-headers && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    # Install PHP extensions
    pecl install grpc && \
    pecl install protobuf && \
    pecl install redis && \
    docker-php-ext-enable grpc protobuf redis
