# Use the PHP image as the base
FROM php:8.3-fpm

# Install required packages and PHP extensions
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get install -y nodejs npm

# Set the working directory
WORKDIR /var/www

# Copy your application files
COPY . .

# Install PHP dependencies with Composer
RUN /usr/local/bin/composer install

# Install JavaScript dependencies with npm, using legacy-peer-deps
RUN npm install --legacy-peer-deps