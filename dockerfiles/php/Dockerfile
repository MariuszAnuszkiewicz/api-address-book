# Use the official PHP Apache image
FROM php:8.1-apache

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Set the working directory in the container
WORKDIR /var/www/html

COPY ../../app/api /var/www
COPY ../../.env /var/www
COPY ../../app/api/public /var/www/html

# Expose port 8101 for the PHP built-in server
EXPOSE 8101

# Run the PHP built-in server
CMD ["php", "-S", "0.0.0.0:8101", "-t", "/var/www/html"]
