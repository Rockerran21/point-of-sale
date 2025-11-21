FROM php:8.1

WORKDIR /app

RUN apt-get update && apt-get install -y \
  libzip-dev \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  zip \
  git \
  default-mysql-client

# Install php extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd exif zip mysqli pdo pdo_mysql

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
  --install-dir=/usr/bin --filename=composer

COPY . /app

RUN composer install --ignore-platform-reqs

# Give execute permission to startup script
RUN chmod +x /app/docker-startup.sh

ENTRYPOINT [ "sh", "/app/docker-startup.sh" ]

