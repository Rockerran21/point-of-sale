FROM php:8.1-fpm

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
  libzip-dev \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  zip \
  unzip \
  git \
  curl \
  nginx \
  supervisor

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
  && apt-get install -y nodejs

# Install PHP extensions
RUN apt-get install -y libpq-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install mysqli pdo pdo_mysql zip gd bcmath

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
  --install-dir=/usr/bin --filename=composer

# Copy application files
COPY . /var/www/html

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm ci && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
  && chmod -R 775 /var/www/html/storage \
  && chmod -R 775 /var/www/html/bootstrap/cache

# Configure Nginx
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Configure Supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port
EXPOSE 80

# Start supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

