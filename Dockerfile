FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    zip \
    unzip \
    git

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create a non-root user
RUN useradd -m symfony

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY --chown=symfony:symfony . .

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip gd

# Switch to non-root user
USER symfony

# Run Composer install
RUN composer install

# Switch back to root user to use default php-fpm command
USER root

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
