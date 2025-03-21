# Dockerfile

# Pull the official PHP 8.3 CLI Alpine-based image from Docker Hub
FROM php:8.3-cli-alpine

# Install system dependencies needed for Composer
RUN apk add --no-cache git zip unzip bash

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Create and switch to the application directory
WORKDIR /app

# Copy composer files first (for caching layers)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-interaction --no-ansi --no-progress --optimize-autoloader

# Now copy the rest of the application source code
COPY . .

# Set the default command (for a CLI app, just run index.php)
CMD ["php", "index.php"]