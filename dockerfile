FROM php:8.2-apache
RUN apt-get update && docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite