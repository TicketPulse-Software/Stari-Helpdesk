#!/bin/bash

# Define the project root directory (update this path as necessary)
PROJECT_ROOT="/path/to/your/project"

# Navigate to the project root directory
cd "$PROJECT_ROOT" || { echo "Project directory not found"; exit 1; }

# Check if composer.json exists
if [ ! -f composer.json ]; then
    echo "composer.json not found. Creating composer.json file..."
    cat <<EOL > composer.json
{
    "name": "stari-helpdesk/main",
    "description": "Stari Helpdesk Project",
    "require": {
        "php": "^7.4 || ^8.0",
        "monolog/monolog": "^2.0",
        "guzzlehttp/guzzle": "^7.0",
        "symfony/var-dumper": "^5.0",
        "phpmailer/phpmailer": "^6.5",
        "google/apiclient": "^2.10",
        "microsoft/microsoft-graph": "^1.50",
        "phpclassic/php-shopify": "^1.0",
        "clicksend/clicksend-php": "^5.0",
        "twilio/sdk": "^6.30"
    },
    "autoload": {
        "psr-4": {
            "App\\\\Admin\\\\": "admin/",
            "App\\\\Agent\\\\": "agent/",
            "App\\\\Customer\\\\": "customer/",
            "App\\\\Includes\\\\": "includes/",
            "App\\\\Public\\\\": "public/"
        }
    }
}
EOL
else
    echo "composer.json already exists. Skipping creation."
fi

# Install Composer if not already installed
if ! command -v composer &> /dev/null; then
    echo "Composer not found, installing Composer..."
    EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

    if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]; then
        echo 'ERROR: Invalid installer signature'
        rm composer-setup.php
        exit 1
    fi

    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    rm composer-setup.php
fi

# Install the required packages
composer install

echo "All packages installed successfully!"
