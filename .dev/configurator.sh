#!/bin/bash

# Color definitions
BLUE='\033[0;34m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${BLUE}"
cat << "EOF"
     _                _ _
    / \   _ __   ___ | | | ___
   / _ \ | '_ \ / _ \| | |/ _ \
  / ___ \| |_) | (_) | | | (_) |
 /_/   \_\ .__/ \___/|_|_|\___/
         |_|
EOF
echo -e "${NC}"

# Print section header
print_header() {
    echo -e "\n${BLUE}=== $1 ===${NC}\n"
}

# Print success message
print_success() {
    echo -e "${GREEN}SUCCESS: $1${NC}"
}

# Print processing message
print_processing() {
    echo -e "${YELLOW}PROCESSING: $1${NC}"
}

# Print error message
print_error() {
    echo -e "${RED}ERROR: $1${NC}"
}

# Main configuration starts
print_header "WordPress Plugin Configurator"
echo "Welcome! Starting plugin configuration process..."
cd ../ # Move to root directory since we're in .dev
echo "Running npm install..."
npm install --silent

# Run npm build:production
print_processing "Building production assets"
if npm run build:production --silent; then
    print_success "Production assets built successfully"
else
    print_error "Failed to build production assets"
    exit 1
fi

# Ask plugin name
echo "Enter Plugin Name (e.g. Apollo):"
read plugin_name
print_processing "Setting up plugin name as: ${plugin_name}"

# Ask text domain
echo "Enter Text Domain (e.g. apollo):"
read text_domain
print_processing "Setting up text domain as: ${text_domain}"

# Ask definition prefix
echo "Enter Definition Prefix (e.g. APOLLO):"
read definition_prefix
print_processing "Setting up definition prefix as: ${definition_prefix}"

# Ask if plugin has frontend functions
echo "Does this plugin have frontend functions? (y/n)"
read has_frontend

print_header "Starting Configuration Process"

# Replace plugin name, text domain and definitions
print_processing "Updating PHP files with new plugin name"
find . -type f -name "*.php" -exec sed -i '' "s/Apollo/${plugin_name}/g" {} +
print_success "Plugin name updated in PHP files"

print_processing "Updating PHP files with new text domain"
find . -type f -name "*.php" -exec sed -i '' "s/apollo/${text_domain}/g" {} +
print_success "Text domain updated in PHP files"

print_processing "Updating PHP files with new definition prefix"
find . -type f -name "*.php" -exec sed -i '' "s/APOLLO_/${definition_prefix}_/g" {} +
print_success "Definition prefix updated in PHP files"

# Update namespaces
print_processing "Updating namespace declarations"
find ./src -type f -name "*.php" -exec sed -i '' "s/namespace Apollo/namespace ${plugin_name}/g" {} +
find ./src -type f -name "*.php" -exec sed -i '' "s/use Apollo/use ${plugin_name}/g" {} +
print_success "Namespace declarations updated"

# Update CSS class names in SCSS files
print_processing "Updating SCSS class names"
find . -type f -name "*.scss" -exec sed -i '' "s/settings_page_apollo/settings_page_${text_domain}/g" {} +
find . -type f -name "*.scss" -exec sed -i '' "s/apollo-welcome/${text_domain}-welcome/g" {} +
print_success "SCSS class names updated"

# Update class names in template files
print_processing "Updating template files"
find ./templates -type f -name "*.php" -exec sed -i '' "s/apollo-welcome/${text_domain}-welcome/g" {} +
print_success "Template files updated"

# Update composer.json
print_processing "Updating composer.json"
sed -i '' "s/\"Apollo\\\\/\"${plugin_name}\\\\/g" composer.json
print_success "Composer.json updated"

print_processing "Running composer install"
composer install
print_success "Composer dependencies installed"

# Update autoloader
print_processing "Regenerating autoloader"
composer dump-autoload -q
print_success "Autoloader regenerated"

# Rename main plugin file
print_processing "Renaming main plugin file"
mv apollo.php ${text_domain}.php
print_success "Main plugin file renamed to ${text_domain}.php"

if [ "$has_frontend" = "n" ]; then
    print_header "Removing Frontend Components"

    print_processing "Removing Frontend folder"
    rm -rf src/Frontend
    print_success "Frontend folder removed"

    print_processing "Updating webpack configuration"
    sed -i '' '/src\/Frontend\/Static\/images/d' .dev/webpack.mix.js
    sed -i '' '/src\/Frontend\/Static\/icons/d' .dev/webpack.mix.js
    sed -i '' '/src\/Frontend\/Static\/fonts/d' .dev/webpack.mix.js
    print_success "Webpack configuration updated"

    print_processing "Updating Init.php"
    sed -i '' "/${plugin_name}\\\\Frontend\\\\Init::instance();/d" src/Core/Controllers/Init.php
    print_success "Init.php updated"

    print_success "All frontend components removed successfully"
else
    print_success "Frontend components will be kept as requested"
fi

print_header "Configuration Complete"
echo -e "${GREEN}Your plugin has been successfully configured with the following settings:${NC}"
echo -e "Plugin Name: ${plugin_name}"
echo -e "Text Domain: ${text_domain}"
echo -e "Definition Prefix: ${definition_prefix}"
echo -e "Frontend Components: $([ "$has_frontend" = "y" ] && echo "Included" || echo "Removed")"

print_header "Next Steps"
echo -e "1. Review the changes in your code editor"
echo -e "2. Test the plugin activation"
