#!/bin/bash

# =============================================================================
# PurchaseCheck Badge for WooCommerce - Build Script
# Creates a distribution ZIP file for WordPress plugin submission
# =============================================================================

# Plugin information
PLUGIN_SLUG="purchasecheck-badge-for-woocommerce"
PLUGIN_VERSION="1.0.0"

# Output directory and filename
BUILD_DIR="./build"
ZIP_FILE="${PLUGIN_SLUG}.zip"

# Files and directories to exclude from the ZIP
EXCLUDE_LIST=(
    "*.git*"
    "*/.gitignore"
    "*/.gitattributes"
    "*/.distignore"
    "*.DS_Store"
    "*/Thumbs.db"
    "*.zip"
    "*/build.sh"
    "*/build/*"
    "*/node_modules/*"
    "*/tests/*"
    "*/test/*"
    "*/phpunit.xml"
    "*/phpunit.xml.dist"
    "*/.phpcs.xml"
    "*/.phpcs.xml.dist"
    "*/phpcs.xml"
    "*/phpcs.xml.dist"
    "*/.eslintrc*"
    "*/.prettierrc*"
    "*/.editorconfig"
    "*/.env"
    "*/.env.*"
    "*/composer.lock"
    "*/package.json"
    "*/package-lock.json"
    "*/yarn.lock"
    "*/webpack.config.js"
    "*/gulpfile.js"
    "*/Gruntfile.js"
    "*/.babelrc"
    "*/.browserslistrc"
    "*.log"
    "*.map"
    "*/.cursor/*"
    "*/.vscode/*"
    "*/.idea/*"
    "*.md"
    "*/CHANGELOG*"
    "*/CONTRIBUTING*"
    "*/LICENSE"
    "*.scss"
    "*.sass"
    "*.less"
    "*/src/*"
    "*/assets/src/*"
)

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo ""
echo "=========================================="
echo "  Building: ${PLUGIN_SLUG}"
echo "  Version:  ${PLUGIN_VERSION}"
echo "=========================================="
echo ""

# Create build directory if it doesn't exist
if [ ! -d "$BUILD_DIR" ]; then
    mkdir -p "$BUILD_DIR"
    echo -e "${GREEN}✓${NC} Created build directory"
fi

# Remove old zip if exists
if [ -f "${BUILD_DIR}/${ZIP_FILE}" ]; then
    rm "${BUILD_DIR}/${ZIP_FILE}"
    echo -e "${YELLOW}✓${NC} Removed old ZIP file"
fi

# Build exclude arguments for zip command
EXCLUDE_ARGS=""
for item in "${EXCLUDE_LIST[@]}"; do
    EXCLUDE_ARGS="$EXCLUDE_ARGS -x \"$item\""
done

# Get the parent directory name (current plugin folder)
CURRENT_DIR=$(basename "$(pwd)")

# Navigate to parent directory to create proper zip structure
cd ..

# Create the ZIP file with the plugin slug as the root folder name
echo -e "${YELLOW}→${NC} Creating ZIP archive..."

# Create zip with proper folder structure
eval "zip -r \"${CURRENT_DIR}/${BUILD_DIR}/${ZIP_FILE}\" \"${CURRENT_DIR}\" ${EXCLUDE_ARGS}"

# Return to plugin directory
cd "${CURRENT_DIR}"

# Check if zip was created successfully
if [ -f "${BUILD_DIR}/${ZIP_FILE}" ]; then
    # Get file size
    FILE_SIZE=$(du -h "${BUILD_DIR}/${ZIP_FILE}" | cut -f1)
    
    echo ""
    echo -e "${GREEN}=========================================="
    echo "  ✓ Build completed successfully!"
    echo "==========================================${NC}"
    echo ""
    echo "  Output: ${BUILD_DIR}/${ZIP_FILE}"
    echo "  Size:   ${FILE_SIZE}"
    echo ""
    echo "  Ready for WordPress.org submission!"
    echo ""
else
    echo ""
    echo -e "${RED}=========================================="
    echo "  ✗ Build failed!"
    echo "==========================================${NC}"
    echo ""
    exit 1
fi
