#!/bin/sh
echo "Running restore tasks..."

# Load database configuration
source ./config/database.conf

# Specify the backup file to restore from (adjust the file name as needed)
backup_file="./backups/backup_to_restore.sql"
files_backup="./backups/files_backup_to_restore.tar.gz"

# Restore the database
echo "Restoring the database from backup..."
mysql -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME < $backup_file

if [ $? -eq 0 ]; then
  echo "Database restore successful."
else
  echo "Database restore failed!"
  exit 1
fi

# Restore the files
echo "Restoring the files from backup..."
tar -xzf $files_backup -C /

if [ $? -eq 0 ]; then
  echo "Files restore successful."
else
  echo "Files restore failed!"
  exit 1
fi

echo "Restore tasks completed."
