# Vercel Deployment Guide - FREE! 🚀

Vercel is free for hobby projects and doesn't require a credit card!

## Quick Deploy (3 Minutes)

### Step 1: Sign Up for Vercel
1. Go to https://vercel.com
2. Click "Sign Up"
3. **Sign up with GitHub** (easiest way)
4. Authorize Vercel to access your repositories

### Step 2: Deploy from GitHub

**Option A: Using Vercel Dashboard (Recommended)**

1. Go to https://vercel.com/new
2. Click "Import Project"
3. Select "Import Git Repository"
4. Choose your repo: `Rockerran21/point-of-sale`
5. Vercel will auto-detect the configuration from `vercel.json`
6. Click "Deploy"

**Option B: Using Vercel CLI**

```bash
# Install Vercel CLI
npm i -g vercel

# Login
vercel login

# Deploy
cd /Users/noobinj3ct3d/POS/triangle-pos
vercel

# Deploy to production
vercel --prod
```

### Step 3: Set Environment Variables

After deployment, add these environment variables in Vercel Dashboard:

1. Go to your project → Settings → Environment Variables
2. Add these variables:

```
APP_NAME=Triangle POS
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.vercel.app
DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-database-username
DB_PASSWORD=your-database-password
```

**Generate APP_KEY locally:**
```bash
php artisan key:generate --show
```

### Step 4: Database Setup

⚠️ **Important:** Vercel is serverless, so you need an external database.

**Free Database Options:**

1. **PlanetScale (Recommended - FREE)**
   - Go to https://planetscale.com
   - Sign up (free tier available)
   - Create a database
   - Copy connection details to Vercel environment variables

2. **Railway MySQL**
   - Go to https://railway.app
   - Create a MySQL database
   - Copy connection string

3. **Aiven MySQL**
   - Go to https://aiven.io
   - Free tier available
   - Create MySQL database

### Step 5: Redeploy

After adding environment variables:
1. Go to Deployments tab
2. Click "Redeploy" on the latest deployment

## Your App is Live! 🎉

Your app will be available at: `https://your-project-name.vercel.app`

## Important Notes

### What Works on Vercel:
✅ PHP serverless functions
✅ Static assets (CSS, JS, images)
✅ Automatic HTTPS
✅ GitHub auto-deployments
✅ Free custom domains

### Limitations:
⚠️ **File Storage:** Vercel's filesystem is read-only
- Use cloud storage for uploads (AWS S3, Cloudinary)
- Configure in `config/filesystems.php`

⚠️ **Database:** Must use external database
- PlanetScale (free)
- Railway
- AWS RDS

⚠️ **Sessions:** Use cookie or database sessions
- Already configured in `vercel.json`

## Troubleshooting

### 500 Error
- Check Vercel logs in dashboard
- Ensure `APP_KEY` is set
- Verify database connection

### Static Assets Not Loading
- Run `npm run build` locally and commit
- Check routes in `vercel.json`

### Database Connection Failed
- Verify environment variables
- Check database host is accessible from internet
- Ensure database allows external connections

## Free Tier Details

✅ **What's FREE:**
- Unlimited deployments
- 100 GB bandwidth per month
- Automatic SSL
- GitHub integration
- Custom domains

Perfect for demos and sharing with friends! 🚀

## Quick Commands

```bash
# Deploy
vercel

# Deploy to production
vercel --prod

# View logs
vercel logs

# List deployments
vercel ls

# Remove deployment
vercel rm [deployment-url]
```

## Next Steps

1. Deploy to Vercel
2. Set up a free database (PlanetScale recommended)
3. Add environment variables
4. Share your URL!

Your app will be at: `https://triangle-pos.vercel.app` (or similar)
