FROM php:8.3-cli

RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    unzip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.* /var/www/html/
COPY . /var/www/html/

WORKDIR /var/www/html

RUN composer install --no-dev --no-scripts

CMD ["php", "-S", "0.0.0.0:8000", "public/index.php"]

