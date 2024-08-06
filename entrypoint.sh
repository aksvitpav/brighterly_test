#!/bin/sh

if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install
fi

php -S 0.0.0.0:8000 -t public