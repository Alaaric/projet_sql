FROM php:8.1-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Install dependencies for Composer and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    libssl-dev \
    && docker-php-ext-install zip pdo_mysql

# Install MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy your custom apache2.conf
COPY apache2.conf /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html