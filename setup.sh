#!/bin/bash

echo "Project setup started..."

if [ ! -f ".env" ]; then
    echo "Creating .env from example"
    cp .env.example .env
fi

echo "Installing composer dependencies..."
composer install

echo "Generating app key..."
php artisan key:generate

echo "Running migrations..."
php artisan migrate

echo "Clearing cache..."
php artisan optimize:clear

echo "Creating storage link..."
php artisan storage:link

echo "Setup completed successfully!"
echo ""
echo "Now run:"
echo "php artisan serve"
