#!/bin/bash

# Build and deploy Docker image to Railway
echo "🐳 Building Docker image for Railway..."

# Build the image locally (using your working Dockerfile)
docker build -t hamro-pos:latest .

# Tag for Railway registry
RAILWAY_PROJECT_ID="ffe82f87-1a3a-4406-bc98-1126613cff94"
docker tag hamro-pos:latest registry.railway.app/$RAILWAY_PROJECT_ID/hamro-pos:latest

# Push to Railway registry
echo "📦 Pushing to Railway registry..."
railway login  # Make sure you're logged in
docker push registry.railway.app/$RAILWAY_PROJECT_ID/hamro-pos:latest

echo "✅ Image pushed! Now update your Railway service to use this image."
echo "📋 In Railway dashboard:"
echo "   1. Go to your service settings"
echo "   2. Change source to 'Docker Image'"
echo "   3. Use: registry.railway.app/$RAILWAY_PROJECT_ID/hamro-pos:latest"