FROM php:8.3-apache

# Arguments defined in docker-compose.yml
ARG PGID
ARG PUID
ARG DEFAULT_USER

# copy the configuration of php
COPY ./docker/config/php.ini "$PHP_INI_DIR/php.ini"
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y \
    curl \
    libpq-dev \
    libicu-dev

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install -y symfony-cli

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl https://cs.symfony.com/download/php-cs-fixer-v3.phar -o php-cs-fixer
RUN chmod a+x php-cs-fixer
RUN mv php-cs-fixer /usr/local/bin/php-cs-fixer

# postgres
RUN docker-php-ext-install pgsql pdo_pgsql pdo

# XDEBUG
RUN pecl install xdebug \
    &&  rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug \
    && touch /var/log/xdebug_remote.log && chmod 777 /var/log/xdebug_remote.log

RUN docker-php-ext-install opcache
RUN docker-php-ext-install intl

COPY ./docker/config/xdebug.ini "$PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini"

# Create system user to run Composer and Artisan Commands
RUN groupadd -g ${PGID} ${DEFAULT_USER} && \
   useradd -l -u ${PUID} -g ${DEFAULT_USER} -m ${DEFAULT_USER} && \
   usermod -p "*" ${DEFAULT_USER} && \
   usermod -a -G ${DEFAULT_USER} www-data && \
   mkdir -p /home/${DEFAULT_USER}/.composer && \
   chown -R ${DEFAULT_USER}:${DEFAULT_USER} /home/${DEFAULT_USER}

RUN a2enmod rewrite
RUN a2enmod headers

# set the workdir
WORKDIR /var/www

USER ${DEFAULT_USER}