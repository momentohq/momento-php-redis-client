FROM mcr.microsoft.com/devcontainers/php:8.1-bookworm

RUN pecl install grpc protobuf redis && docker-php-ext-enable grpc protobuf redis
