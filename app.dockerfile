FROM php:fpm

ENV USER=www
ENV GROUP=www

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev

# Install Postgres PDO
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd
# Install XDebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Clear apt cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www

# Install libraries
COPY composer.lock composer.json /var/www/
RUN composer install --no-dev --no-scripts

# Create User and Group
RUN groupadd -g 1000 ${GROUP} && useradd -u 1000 -ms /bin/bash -g ${GROUP} ${USER}

# Grant Permissions
RUN chown -R ${USER} /var/www

# Change / select user
USER ${USER}

# Copy everything, except what's in .dockerignore
# Our working directory is /var/www so the second . becomes /var/www
# It also chowns the copied files
COPY --chown=${USER}:${GROUP} . .
