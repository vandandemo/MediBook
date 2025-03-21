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
    nginx \
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

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN chmod -R 777 storage bootstrap/cache
RUN chmod -R 777 public
RUN chmod -R 777 vendor

# Configure Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Remove default nginx welcome page
RUN rm /var/www/html/index.nginx-debian.html

# Expose port 80
EXPOSE 80

# Create startup script
RUN echo '#!/bin/bash\n\
# Copy .env.example to .env if .env does not exist\n\
if [ ! -f .env ]; then\n\
    cp .env.example .env\n\
fi\n\
\n\
# Generate application key if not exists\n\
if [ ! -f .env ]; then\n\
    php artisan key:generate --force\n\
fi\n\
\n\
# Create storage link\n\
php artisan storage:link --force\n\
\n\
# Clear and cache config\n\
php artisan config:clear && php artisan config:cache\n\
php artisan route:clear && php artisan route:cache\n\
php artisan view:clear && php artisan view:cache\n\
\n\
# Set proper permissions\n\
chown -R www-data:www-data /var/www/html\n\
chmod -R 755 /var/www/html\n\
chmod -R 777 storage bootstrap/cache public vendor\n\
\n\
# Start PHP-FPM\n\
php-fpm -D\n\
\n\
# Start Nginx\n\
nginx -g "daemon off;"' > /start.sh && chmod +x /start.sh

# Start Nginx & PHP-FPM
CMD ["/start.sh"]
