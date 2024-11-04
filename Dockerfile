FROM php:8.1-fpm

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Set working directory
WORKDIR /var/www/html

# Copy all project files to the container
COPY . /var/www/html

# Set file permissions
RUN chown -R www-data:www-data /var/www/html
FROM php:8.1-fpm

# Install extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html