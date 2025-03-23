# deploy/Dockerfile

# stage 1: build stage
FROM php:8.4-fpm-alpine 

# installing system dependencies and php extensions
RUN apk add --no-cache \
    zip \
    libzip-dev \
    freetype \
    libjpeg-turbo \
    libpng \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    nodejs \
    npm \
    nginx \
    supervisor \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install zip pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd

# install composer

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer self-update
RUN command -v composer
# COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ../nginx/nginx.conf /etc/nginx/http.d/default.conf
COPY ./deploy_php8/php.ini "$PHP_INI_DIR/conf.d/app.ini"

# CMD ["sh", "-c","supervisord", "/etc/supervisord.conf","nginx && php-fpm"]
CMD ["supervisord", "-c", "/etc/supervisord.conf"]

