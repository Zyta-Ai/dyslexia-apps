#!/bin/bash
# Railway Build Script
echo "🚀 Starting Railway Build Process..."

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies
echo "📦 Installing Node dependencies..."
npm ci

# Build assets
echo "🔨 Building assets..."
npm run build

# Optimize Laravel
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "✅ Build completed successfully!"