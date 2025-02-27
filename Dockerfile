# Use an official PHP image with Apache
FROM php:8.2-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy all project files into the container
COPY . /var/www/html/

# Enable Apache mod_rewrite (for Laravel or clean URLs)
RUN a2enmod rewrite

# Expose port 80 for the web server
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
