# Use the official PHP image
FROM php:8.4-fpm

# Set the working directory inside the container
WORKDIR /var/www/html

# Install required PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    git \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Copy the Laravel project files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Install NPM dependencies and build assets
RUN npm install
RUN npm run build

# Set permissions for storage and bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# Expose port 9000
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
