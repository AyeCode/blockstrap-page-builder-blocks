#!/bin/bash

# Function to display usage
usage() {
    echo "Usage: $0 [-d plugin-directory] [-z zip-file-name] [-v versioning]"
    echo "  -d  Plugin directory (default: current directory)"
    echo "  -z  Output zip file name (default: plugin.zip)"
    echo "  -v  Enable versioning from package.json (default: false)"
    exit 1
}

# Check if required tools are installed
if ! command -v zip &> /dev/null; then
    echo "zip not found! Please install zip before proceeding."
    exit 1
fi

# Default values
PLUGIN_DIR="."
ZIP_FILE="blockstrap-page-builder-blocks.zip"
USE_VERSIONING=false

# Parse command-line options
while getopts "d:z:v" opt; do
    case $opt in
        d) PLUGIN_DIR="$OPTARG" ;;
        z) ZIP_FILE="$OPTARG" ;;
        v) USE_VERSIONING=true ;;
        *) usage ;;
    esac
done

# Change to the plugin directory
cd "$PLUGIN_DIR" || { echo "Error: Plugin directory not found."; exit 1; }

# Remove any existing zip file
if [ -f "$ZIP_FILE" ]; then
    rm "$ZIP_FILE"
fi

# Zip the plugin directory, excluding unwanted files
echo "Creating zip file..."

zip -r "./$ZIP_FILE" . \
    -x "node_modules/*" \
    ".git/*" \
    ".vscode/*" \
    "tests/*" \
    "build/*" \
    "src/*" \
    "*.log" \
    "*.zip" \
    "*.css.map" \
    "*.js.map" \
    "build.sh" \
    "package.json" \
    "package-lock.json" \
    "webpack.config.prod.js" \
    "webpack.config.base.js" \
    "webpack.config.dev.js" \
    "package-lock.json"

# Check if zip was successful
if [ $? -eq 0 ]; then
    echo "Plugin zip file created successfully: $ZIP_FILE"
else
    echo "Error: Failed to create zip file."
    exit 1
fi
