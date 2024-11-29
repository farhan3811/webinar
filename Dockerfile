# Use an official PHP image as the base image
FROM php:8.1-fpm

# Set the working directory inside the container
WORKDIR /var/www

# Install system dependencies and PHP extensions required for Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer (PHP package manager) globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Laravel application code into the container
COPY . .

# Install Laravel dependencies via Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expose port 9000 (PHP-FPM default)
EXPOSE 9090

# Start the PHP-FPM server
CMD ["php-fpm"]
