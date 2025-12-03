#!/bin/bash

# IKICB Deployment Script
# This script helps you deploy your Laravel application to the server
# Since npm is not available on the server, we build assets locally

echo "================================================"
echo "   IKICB Deployment Script"
echo "================================================"
echo ""

# Step 1: Build assets locally
echo "📦 Step 1: Building production assets..."
npm run build

if [ $? -ne 0 ]; then
    echo "❌ Build failed! Please check for errors."
    exit 1
fi
echo "✅ Assets built successfully"
echo ""

# Step 2: Add built assets to git
echo "📝 Step 2: Adding built assets to git..."
git add public/build
echo "✅ Assets staged"
echo ""

# Step 3: Commit changes
echo "💾 Step 3: Creating commit..."
read -p "Enter commit message (or press Enter for default): " commit_msg
if [ -z "$commit_msg" ]; then
    commit_msg="Deploy: Update production assets and code"
fi

git commit -m "$commit_msg

🤖 Generated with [Claude Code](https://claude.com/claude-code)

Co-Authored-By: Claude <noreply@anthropic.com>"

if [ $? -ne 0 ]; then
    echo "⚠️  Nothing to commit or commit failed"
else
    echo "✅ Committed successfully"
fi
echo ""

# Step 4: Push to repository
echo "🚀 Step 4: Pushing to GitHub..."
git push origin main

if [ $? -ne 0 ]; then
    echo "❌ Push failed! Please check your connection."
    exit 1
fi
echo "✅ Pushed to GitHub successfully"
echo ""

# Step 5: Instructions for server
echo "================================================"
echo "   🎉 Ready to Deploy!"
echo "================================================"
echo ""
echo "Now run these commands on your SERVER:"
echo ""
echo "  1. cd /path/to/your/project"
echo "  2. git pull origin main"
echo "  3. php artisan config:clear"
echo "  4. php artisan cache:clear"
echo "  5. php artisan view:clear"
echo ""
echo "Your site should be live at: https://ikicbcampus.com"
echo ""
echo "================================================"
