FROM php:8.3-cli

RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

COPY . /var/www/html/

WORKDIR /var/www/html

CMD ["php", "-S", "0.0.0.0:8000", "index.php"]
