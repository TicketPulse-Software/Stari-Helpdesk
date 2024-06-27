#!/bin/bash

# Check if composer is installed
if ! command -v composer &> /dev/null
then
    echo "Composer could not be found, please install it first."
    exit
fi

# Check if mysql is installed
if ! command -v mysql &> /dev/null
then
    echo "MySQL could not be found, please install it first."
    exit
fi

# Function to prompt for user input or generate random database name
generate_random_db_name() {
    echo "Would you like to enter a database name or generate a random one? (enter/generate)"
    read choice
    if [ "$choice" == "enter" ]; then
        echo "Please enter the database name:"
        read db_name
    else
        db_name="db_$(openssl rand -hex 5)"
        echo "Random database name generated: $db_name"
    fi
    echo $db_name
}

# Prompt for user input to create the .env file
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cat <<EOT >> .env
# Gmail API settings
GMAIL_CLIENT_ID=$(read -p "Enter your Gmail Client ID: " GMAIL_CLIENT_ID && echo $GMAIL_CLIENT_ID)
GMAIL_CLIENT_SECRET=$(read -p "Enter your Gmail Client Secret: " GMAIL_CLIENT_SECRET && echo $GMAIL_CLIENT_SECRET)
GMAIL_REDIRECT_URI=$(read -p "Enter your Gmail Redirect URI: " GMAIL_REDIRECT_URI && echo $GMAIL_REDIRECT_URI)
GMAIL_REFRESH_TOKEN=$(read -p "Enter your Gmail Refresh Token: " GMAIL_REFRESH_TOKEN && echo $GMAIL_REFRESH_TOKEN)

# Outlook API settings
OUTLOOK_CLIENT_ID=$(read -p "Enter your Outlook Client ID: " OUTLOOK_CLIENT_ID && echo $OUTLOOK_CLIENT_ID)
OUTLOOK_CLIENT_SECRET=$(read -p "Enter your Outlook Client Secret: " OUTLOOK_CLIENT_SECRET && echo $OUTLOOK_CLIENT_SECRET)
OUTLOOK_REDIRECT_URI=$(read -p "Enter your Outlook Redirect URI: " OUTLOOK_REDIRECT_URI && echo $OUTLOOK_REDIRECT_URI)
OUTLOOK_REFRESH_TOKEN=$(read -p "Enter your Outlook Refresh Token: " OUTLOOK_REFRESH_TOKEN && echo $OUTLOOK_REFRESH_TOKEN)

# SMTP settings
SMTP_HOST=$(read -p "Enter your SMTP Host: " SMTP_HOST && echo $SMTP_HOST)
SMTP_PORT=$(read -p "Enter your SMTP Port: " SMTP_PORT && echo $SMTP_PORT)
SMTP_USERNAME=$(read -p "Enter your SMTP Username: " SMTP_USERNAME && echo $SMTP_USERNAME)
SMTP_PASSWORD=$(read -p "Enter your SMTP Password: " SMTP_PASSWORD && echo $SMTP_PASSWORD)
SMTP_ENCRYPTION=$(read -p "Enter your SMTP Encryption (tls/ssl): " SMTP_ENCRYPTION && echo $SMTP_ENCRYPTION)

# Database settings
DB_HOST=$(read -p "Enter your Database Host: " DB_HOST && echo $DB_HOST)
DB_PORT=$(read -p "Enter your Database Port: " DB_PORT && echo $DB_PORT)
DB_DATABASE=$(generate_random_db_name)
DB_USERNAME=$(read -p "Enter your Database Username: " DB_USERNAME && echo $DB_USERNAME)
DB_PASSWORD=$(read -p "Enter your Database Password: " DB_PASSWORD && echo $DB_PASSWORD)

# Shopify API settings
SHOPIFY_SHOP_URL=$(read -p "Enter your Shopify Shop URL: " SHOPIFY_SHOP_URL && echo $SHOPIFY_SHOP_URL)
SHOPIFY_API_KEY=$(read -p "Enter your Shopify API Key: " SHOPIFY_API_KEY && echo $SHOPIFY_API_KEY)
SHOPIFY_API_SECRET=$(read -p "Enter your Shopify API Secret: " SHOPIFY_API_SECRET && echo $SHOPIFY_API_SECRET)
SHOPIFY_ACCESS_TOKEN=$(read -p "Enter your Shopify Access Token: " SHOPIFY_ACCESS_TOKEN && echo $SHOPIFY_ACCESS_TOKEN)

# Domain settings
DOMAIN=$(read -p "Enter your Domain: " DOMAIN && echo $DOMAIN)
EOT
    echo ".env file created. Please update it with your configuration."
else
    echo ".env file already exists. Please ensure it is updated with your configuration."
fi

# Install necessary PHP libraries
echo "Installing PHP libraries using Composer..."

composer require vlucas/phpdotenv phpmailer/phpmailer league/oauth2-google microsoft/microsoft-graph google/apiclient:^2.15.0 phpclassic/php-shopify

echo "Installation complete."

# Create config.php file with placeholders if it doesn't exist
if [ ! -f config.php ]; then
    echo "Creating config.php file..."
    cat <<EOT >> config.php
<?php
// Database settings
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USERNAME'));
define('DB_PASS', getenv('DB_PASSWORD'));
define('DB_NAME', getenv('DB_DATABASE'));
define('DB_PORT', getenv('DB_PORT'));

// Gmail API settings
define('GMAIL_CLIENT_ID', getenv('GMAIL_CLIENT_ID'));
define('GMAIL_CLIENT_SECRET', getenv('GMAIL_CLIENT_SECRET'));
define('GMAIL_REDIRECT_URI', getenv('GMAIL_REDIRECT_URI'));

// Outlook API settings
define('OUTLOOK_CLIENT_ID', getenv('OUTLOOK_CLIENT_ID'));
define('OUTLOOK_CLIENT_SECRET', getenv('OUTLOOK_CLIENT_SECRET'));
define('OUTLOOK_REDIRECT_URI', getenv('OUTLOOK_REDIRECT_URI'));

// Shopify API settings
define('SHOPIFY_SHOP_URL', getenv('SHOPIFY_SHOP_URL'));
define('SHOPIFY_API_KEY', getenv('SHOPIFY_API_KEY'));
define('SHOPIFY_API_SECRET', getenv('SHOPIFY_API_SECRET'));
define('SHOPIFY_ACCESS_TOKEN', getenv('SHOPIFY_ACCESS_TOKEN'));

// SMTP settings
define('SMTP_HOST', getenv('SMTP_HOST'));
define('SMTP_PORT', getenv('SMTP_PORT'));
define('SMTP_USERNAME', getenv('SMTP_USERNAME'));
define('SMTP_PASSWORD', getenv('SMTP_PASSWORD'));
define('SMTP_ENCRYPTION', getenv('SMTP_ENCRYPTION'));

// Domain settings
define('DOMAIN', getenv('DOMAIN'));
?>
EOT
    echo "config.php file created. Please update it with your configuration."
else
    echo "config.php file already exists. Please ensure it is updated with your configuration."
fi

# Load environment variables from .env file
if [ -f .env ]; then
    export $(cat .env | sed 's/#.*//g' | xargs)
else
    echo ".env file not found. Aborting database setup."
    exit 1
fi

# Create the database if it doesn't exist
echo "Creating database if it doesn't exist..."
mysql -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD -e "CREATE DATABASE IF NOT EXISTS $DB_DATABASE;"

if [ $? -eq 0 ]; then
    echo "Database '$DB_DATABASE' created or already exists."
else
    echo "Failed to create database '$DB_DATABASE'. Please check your MySQL credentials and try again."
    exit 1
fi

# Create necessary tables in the database
echo "Creating tables in the database..."
mysql -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE <<EOT
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'agent', 'customer') NOT NULL
);

CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    customer_id INT NOT NULL,
    status ENUM('open', 'closed') DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS replies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS integrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    provider VARCHAR(50) NOT NULL,
    client_id VARCHAR(255) NOT NULL,
    client_secret VARCHAR(255) NOT NULL,
    redirect_uri VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS shopify_integrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    shop_name VARCHAR(255) NOT NULL,
    access_token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
EOT

if [ $? -eq 0 ]; then
    echo "Tables created successfully."
else
    echo "Failed to create tables. Please check your MySQL credentials and try again."
    exit 1
fi
