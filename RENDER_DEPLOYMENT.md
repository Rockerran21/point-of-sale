# Render Deployment Guide - 100% FREE

Render is perfect for Laravel and connects directly to GitHub!

## Quick Deploy (3 Minutes)

### Step 1: Sign Up for Render
1. Go to https://render.com
2. Click "Get Started for Free"
3. **Sign up with GitHub** (this is important!)
4. Authorize Render to access your repositories

### Step 2: Deploy from GitHub

**Option A: Using Blueprint (Easiest - One Click)**

1. Go to https://dashboard.render.com
2. Click "New" → "Blueprint"
3. Connect your GitHub repository: `Rockerran21/point-of-sale`
4. Render will detect `render.yaml` and set everything up automatically
5. Click "Apply" - Done! ✅

**Option B: Manual Setup**

1. Go to https://dashboard.render.com
2. Click "New" → "Web Service"
3. Connect your GitHub account if not already connected
4. Select repository: `Rockerran21/point-of-sale`
5. Configure:
   - **Name**: triangle-pos
   - **Environment**: Docker (or Native if available)
   - **Build Command**: 
     ```
     composer install --no-dev --optimize-autoloader && npm ci && npm run build
     ```
   - **Start Command**: 
     ```
     php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
     ```
6. Click "Create Web Service"

### Step 3: Add Database

1. In Render Dashboard, click "New" → "PostgreSQL" (FREE tier available)
   - Or use "MySQL" if you prefer (may require paid plan)
2. Name it: `triangle-pos-db`
3. Select "Free" plan
4. Click "Create Database"

### Step 4: Connect Database to App

1. Go to your web service
2. Click "Environment" tab
3. Add these variables:
   - `DATABASE_URL`: Copy from your PostgreSQL database (Internal Database URL)
   - `DB_CONNECTION`: `pgsql` (or `mysql` if using MySQL)
   - `APP_KEY`: Generate locally (see below)
   - `APP_NAME`: `Triangle POS`
   - `APP_ENV`: `production`
   - `APP_DEBUG`: `false`

**Generate APP_KEY:**
```bash
php artisan key:generate --show
```
Copy the output (looks like: `base64:xxxxxxxxxxxxx`)

### Step 5: Deploy!

1. Click "Manual Deploy" → "Deploy latest commit"
2. Wait 3-5 minutes
3. Your app will be live at: `https://triangle-pos.onrender.com`

## Free Tier Details

✅ **What's FREE:**
- Web service (with some limitations)
- PostgreSQL database (256 MB)
- Automatic SSL
- Automatic deployments from GitHub
- Custom domain support

⚠️ **Limitations:**
- Service spins down after 15 minutes of inactivity
- First request after spin-down takes ~30 seconds to wake up
- 750 hours/month of runtime (plenty for demos)

## Alternative: Use PostgreSQL Instead of MySQL

Since Render's free tier includes PostgreSQL, update your `.env` to use it:

```env
DB_CONNECTION=pgsql
DB_HOST=your-db-host.render.com
DB_PORT=5432
DB_DATABASE=triangle_pos
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

Or just use `DATABASE_URL` (Render provides this automatically).

## Troubleshooting

### Can't Find Repository
1. Make sure you signed up with GitHub
2. Go to Account Settings → Connected Accounts
3. Reconnect GitHub and grant access to your repositories

### Build Fails
- Check build logs in Render dashboard
- Ensure `composer.json` and `package.json` are valid
- Make sure PHP version is compatible (add `"php": "^8.1"` in composer.json)

### Database Connection Error
- Copy the "Internal Database URL" from your database
- Paste it as `DATABASE_URL` in your web service environment variables
- Make sure `DB_CONNECTION` is set to `pgsql`

## Sharing Your App

Your app will be at:
```
https://triangle-pos.onrender.com
```

Share this URL with anyone! 🎉

**Note:** First load after inactivity takes ~30 seconds (free tier limitation).

## Keep Your App Awake (Optional)

To prevent spin-down, use a free uptime monitor:
- UptimeRobot: https://uptimerobot.com (ping your app every 5 minutes)
- Cron-job.org: https://cron-job.org

## Cost

**100% FREE** for:
- Small projects
- Demos
- Testing
- Sharing with friends

Perfect for your use case! 🚀
