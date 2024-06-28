#!/bin/bash
echo "Running build tasks..."

# Check if composer is installed
if ! command -v composer &> /dev/null
then
    echo "Composer could not be found, please install it first."
    exit 1
fi

# Check if npm is installed
if ! command -v npm &> /dev/null
then
    echo "npm could not be found, please install it first."
    exit 1
fi

# Load environment variables from .env file
if [ -f .env ]; then
    export $(cat .env | sed 's/#.*//g' | xargs)
else
    echo ".env file not found. Aborting build."
    exit 1
fi

# Install PHP dependencies
echo "Installing PHP dependencies using Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader

if [ $? -eq 0 ]; then
    echo "PHP dependencies installed successfully."
else
    echo "PHP dependency installation failed!"
    exit 1
fi

# Install Node.js dependencies
echo "Installing Node.js dependencies using npm..."
npm install

if [ $? -eq 0 ]; then
    echo "Node.js dependencies installed successfully."
else
    echo "Node.js dependency installation failed!"
    exit 1
fi

# Compile assets
echo "Compiling assets..."
npm run production

if [ $? -eq 0 ]; then
    echo "Assets compiled successfully."
else
    echo "Asset compilation failed!"
    exit 1
fi

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

if [ $? -eq 0 ]; then
    echo "Database migrations completed successfully."
else
    echo "Database migrations failed!"
    exit 1
fi

# Seed the database (optional)
echo "Seeding the database..."
php artisan db:seed --force

if [ $? -eq 0 ]; then
    echo "Database seeding completed successfully."
else
    echo "Database seeding failed!"
    exit 1
fi

# Clear and cache configurations
echo "Clearing and caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ $? -eq 0 ]; then
    echo "Configuration cache cleared and updated successfully."
else
    echo "Configuration cache update failed!"
    exit 1
fi

echo "Build tasks completed successfully."
