#!/bin/sh
echo "Running backup tasks..."

# Load database configuration
source ./config/database.conf

# Create a timestamp variable
timestamp=$(date +%F_%T)

# Backup the database
echo "Backing up the database..."
backup_file="./backups/db_backup_$timestamp.sql"
mysqldump -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME > $backup_file

if [ $? -eq 0 ]; then
  echo "Database backup successful: $backup_file"
else
  echo "Database backup failed!"
  exit 1
fi

# Backup important files
echo "Backing up important files..."
# Specify the directories you want to back up
directories_to_backup=("public" "config" "resources" "storage")
backup_tar="./backups/files_backup_$timestamp.tar.gz"

tar -czf $backup_tar ${directories_to_backup[@]}

if [ $? -eq 0 ]; then
  echo "Files backup successful: $backup_tar"
else
  echo "Files backup failed!"
  exit 1
fi

echo "Backup tasks completed."
