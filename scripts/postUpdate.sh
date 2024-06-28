#!/bin/sh
echo "Running post-update tasks..."

# Example: Run database migrations
echo "Running database migrations..."
php artisan migrate --force

if [ $? -eq 0 ]; then
  echo "Database migrations completed successfully."
else
  echo "Database migrations failed!"
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

echo "Post-update tasks completed."
