#!/bin/sh
echo "Running pre-backup tasks..."

# Load database configuration
source ./config/database.conf

# Create backups directory if it doesn't exist
mkdir -p ./backups

# Check disk space before starting backup
echo "Checking disk space..."
df -h .

if [ $? -eq 0 ]; then
  echo "Disk space check successful."
else
  echo "Disk space check failed!"
  exit 1
fi

echo "Pre-backup tasks completed."
