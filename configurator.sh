#!/bin/bash

# Ask plugin name
echo "Enter Plugin Name (e.g. Apollo):"
read plugin_name

# Ask text domain
echo "Enter Text Domain (e.g. apollo):"
read text_domain

# Ask definition prefix
echo "Enter Definition Prefix (e.g. APOLLO):"
read definition_prefix

# Ask if plugin has frontend functions
echo "Does this plugin have frontend functions? (y/n)"
read has_frontend

# Replace plugin name, text domain and definitions
find . -type f -name "*.php" -exec sed -i '' "s/Apollo/${plugin_name}/g" {} +
find . -type f -name "*.php" -exec sed -i '' "s/apollo/${text_domain}/g" {} +
find . -type f -name "*.php" -exec sed -i '' "s/APOLLO_/${definition_prefix}_/g" {} +

# Update namespaces
find ./src -type f -name "*.php" -exec sed -i '' "s/namespace Apollo/namespace ${plugin_name}/g" {} +
find ./src -type f -name "*.php" -exec sed -i '' "s/use Apollo/use ${plugin_name}/g" {} +

if [ "$has_frontend" = "n" ]; then
    # Remove Frontend folder
    rm -rf src/Frontend

    # Update webpack.mix.js - remove frontend related configs
    sed -i '' '/src\/Frontend\/Static\/images/d' .dev/webpack.mix.js
    sed -i '' '/src\/Frontend\/Static\/icons/d' .dev/webpack.mix.js
    sed -i '' '/src\/Frontend\/Static\/fonts/d' .dev/webpack.mix.js

    # Update Init.php - remove Frontend init
    sed -i '' "/${plugin_name}\\\\Frontend\\\\Init::instance();/d" src/Core/Controllers/Init.php

    echo "Frontend components removed successfully!"
else
    echo "Frontend components will be kept"
fi

echo "Plugin configuration completed successfully!"
