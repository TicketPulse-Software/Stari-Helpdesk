#!/bin/bash
echo "Running pre-deploy tasks..."

# Load database configuration
source ./config/database.conf

# Create backups directory if it doesn't exist
mkdir -p ./backups

# Backup the current database
echo "Backing up the current database..."
backup_file="backup_before_deploy_$(date +%F_%T).sql"
mysqldump -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE > ./backups/$backup_file

if [ $? -eq 0 ]; then
  echo "Database backup successful: $backup_file"
else
  echo "Database backup failed!"
  exit 1
fi

# Pull the latest code from the repository
echo "Pulling the latest code from the repository..."
git pull origin main

if [ $? -eq 0 ]; then
  echo "Code pull successful."
else
  echo "Code pull failed!"
  exit 1
fi

echo "Pre-deploy tasks completed."
