FROM wordpress:latest

# Install X-Debug via PECL and enable it
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# (Optional) Adjust X-Debug configuration here if not mounting from custom-php.ini
# Copy a sample custom-php.ini if you prefer to bake the settings:
# COPY custom-php.ini /usr/local/etc/php/conf.d/

# Copy composer from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy the composer file to install WordPress stubs (for VSCode autocompletion)
COPY composer.json /var/www/html/composer.json

# Install the stubs (and any additional dependencies)
RUN composer install --no-interaction

EXPOSE 80
