#!/bin/bash

# Configuration
SCRIPT_DIR="$(dirname "$(realpath "$0")")"  # Get the directory where the script is located
BACKUP_DIR="$SCRIPT_DIR/backups"            # Directory to store the backup
GITHUB_REPO="HusseinHDTS/V2RayPanel"   # GitHub repo in "username/repo" format

# Get current date in format YYYY-MM-DD
CURRENT_DATE=$(date +"%Y-%m-%d")

# Name the backup file with the current date
BACKUP_FILE="$BACKUP_DIR/backup-$CURRENT_DATE.tar.gz"

# Create the backup directory if it doesn't exist
mkdir -p "$BACKUP_DIR"

# Exclude the vendor folder and other unwanted files or folders
tar --exclude="$SCRIPT_DIR/vendor" \
    --exclude="$SCRIPT_DIR/node_modules" \
    --exclude="$SCRIPT_DIR/build" \
    --exclude="$SCRIPT_DIR/apk" \
    -czf "$BACKUP_FILE" -C "$SCRIPT_DIR" .

# Push the backup to GitHub release
gh release create "$CURRENT_DATE" "$BACKUP_FILE" --repo "$GITHUB_REPO" --title "Backup - $CURRENT_DATE" --notes "Daily backup for $CURRENT_DATE"

# Optional: Remove the local backup file after uploading (uncomment if needed)
# rm "$BACKUP_FILE"