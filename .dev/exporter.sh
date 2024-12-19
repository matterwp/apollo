#!/bin/bash

# Ask for the name of the file
echo "What is the name of the file?"
read name

# Validate input
if [ -z "$name" ]; then
    echo "Error: File name cannot be empty"
    exit 1
fi

# Define an array of files and directories to exclude
exclude=(
    "node_modules/*"
    ".git/*"
    ".env"
    ".editorconfig"
    ".prettierrc"
    ".stylelintrc"
    ".yarnrc.yml"
    "composer.lock"
    ".yarn/*"
    "mix-manifest.json"
    "package.json"
    "safelist.txt"
    "tailwind.config.js"
    "webpack.mix.js"
    "yarn.lock"
    ".gitignore"
    "vendor/squizlabs/*"
    "vendor/wp-coding-standards/*"
    ".dev/*"
    "src/Admin/Static/*"
    "src/Frontend/Static/*"
		"export.sh"
		".DS_Store"
		".cursorignore"
		"translations.sh"
		"vendor/bin/*"
		"dist/mix-manifest.json"
		"configurator.sh"
		"package-lock.json"
)

# Create a temporary exclusion file
temp_exclude_file=$(mktemp)

# Write exclusion patterns to the temporary file
for pattern in "${exclude[@]}"; do
    echo "$pattern" >> "$temp_exclude_file"
done

# Create the zip file with exclusions
if zip -r "$name.zip" . -x@"$temp_exclude_file"; then
    echo "Successfully created $name.zip"
else
    echo "Error: Failed to create zip file"
    rm "$temp_exclude_file"
    exit 1
fi

# Clean up the temporary file
rm "$temp_exclude_file"

# Create .deployment directory if it doesn't exist
mkdir -p .deployment

# Move zip file to .deployment folder
if mv "$name.zip" .deployment/; then
    echo "Export completed successfully!"
    echo "File location: $(pwd)/.deployment/$name.zip"
else
    echo "Error: Failed to move zip file to .deployment folder"
    exit 1
fi
