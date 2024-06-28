#!/bin/sh
echo "Running deploy tasks..."

# Load database configuration
source ./config/database.conf

# Install dependencies
echo "Installing dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

if [ $? -eq 0 ]; then
  echo "Dependencies installed successfully."
else
  echo "Dependency installation failed!"
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

# Restart the server
echo "Restarting the server..."
# Replace this with your actual server restart command
# e.g., systemctl restart apache2 or systemctl restart nginx
# Here is an example for Apache
sudo systemctl restart apache2

if [ $? -eq 0 ]; then
  echo "Server restarted successfully."
else
  echo "Server restart failed!"
  exit 1
fi

echo "Deploy tasks completed."
