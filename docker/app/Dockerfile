FROM php:8.1-fpm

# Arguments defined in docker-compose.yml
#ARG user
#ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    openssh-client \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    mc \
    htop \
    nano \
    cron \
    procps \
    supervisor \
    jpegoptim \
    optipng \
    pngquant


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd xml

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user
#RUN useradd -G www-data,root -u $uid -d /home/$user $user

# Create composer dir
#RUN mkdir -p /home/$user/.composer
RUN mkdir -p /home/root/.composer

# Add SSH-key & access to github.com
#RUN mkdir -p -m 0700 /home/$user/.ssh \
#&& ssh-keyscan github.com >> /home/$user/.ssh/known_hosts
RUN mkdir -p -m 0700 /home/root/.ssh \
&& ssh-keyscan github.com >> /home/root/.ssh/known_hosts

# Try copy ssh private-key (from root dir of the project)
#COPY id_rsa /home/$user/.ssh/id_rsa

# Set owner for home user directory
#RUN chown -R $user:$user /home/$user
#RUN chmod 0700 /home/$user/.ssh/id_rsa

# Set working directory
WORKDIR /var/www

# Copy project
COPY . .

#RUN chown -R $user:www-data /var/www
RUN chown -R root:www-data /var/www
RUN chmod +x artisan

RUN cron

#USER $user

# Add the cron job
#RUN crontab -l | { cat; echo "* * * * * cd /var/www && php artisan schedule:run >> /dev/null 2>&1"; } | crontab -

#RUN composer install
