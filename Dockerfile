FROM wordpress:latest

# Update package lists and install required packages
RUN apt-get update && apt-get install -y curl

# Install X-Debug via PECL and enable it
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install WP-CLI (latest)
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# Copy Composer from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory to the WordPress installation
WORKDIR /var/www/html

# Copy composer.json to install WordPress stubs (and other dev dependencies)
COPY composer.json /var/www/html/composer.json

# Install Composer dependencies
RUN composer install --no-interaction

EXPOSE 80