#!/bin/bash

# Add all environment variables to Vercel production
echo "Adding environment variables to Vercel..."

vercel env add APP_ENV --value="production" --environment=production --yes
vercel env add APP_KEY --value="base64:lKIvcp4rWgtWv4KJnhKQiVcmbecXWlbD9fZaQ2ml/5A=" --environment=production --yes
vercel env add APP_DEBUG --value="false" --environment=production --yes
vercel env add LOG_CHANNEL --value="stderr" --environment=production --yes
vercel env add DB_CONNECTION --value="pgsql" --environment=production --yes
vercel env add DB_HOST --value="db.zqgotbyyhfpepagwxgre.supabase.co" --environment=production --yes
vercel env add DB_PORT --value="5432" --environment=production --yes
vercel env add DB_DATABASE --value="postgres" --environment=production --yes
vercel env add DB_USERNAME --value="postgres" --environment=production --yes
vercel env add DB_PASSWORD --value="Ranjan@79115" --environment=production --yes
vercel env add DB_SSLMODE --value="require" --environment=production --yes
vercel env add SESSION_DRIVER --value="cookie" --environment=production --yes
vercel env add SESSION_LIFETIME --value="120" --environment=production --yes
vercel env add CACHE_DRIVER --value="array" --environment=production --yes
vercel env add QUEUE_CONNECTION --value="sync" --environment=production --yes
vercel env add FILESYSTEM_DRIVER --value="cloudinary" --environment=production --yes
vercel env add CLOUDINARY_CLOUD_NAME --value="dm246knqi" --environment=production --yes
vercel env add CLOUDINARY_API_KEY --value="824551532467775" --environment=production --yes
vercel env add CLOUDINARY_API_SECRET --value="wsvwgoJDJwWXW7qtu7dgUJe0mq8" --environment=production --yes
vercel env add CLOUDINARY_UPLOAD_PRESET --value="hamro_pos_uploads" --environment=production --yes
vercel env add VIEW_COMPILED_PATH --value="/tmp/views" --environment=production --yes
vercel env add APP_STORAGE --value="/tmp" --environment=production --yes
vercel env add BCRYPT_ROUNDS --value="10" --environment=production --yes

echo "All environment variables added!"