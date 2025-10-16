# Railway Deployment Guide - FREE Hosting

## Quick Deploy (5 Minutes)

### Step 1: Sign Up for Railway
1. Go to https://railway.app
2. Click "Login" and sign in with your GitHub account
3. You get **$5 free credit per month** (enough for small projects)

### Step 2: Deploy Your Project

1. Click "New Project" on Railway dashboard
2. Select "Deploy from GitHub repo"
3. Choose your repository: `Rockerran21/point-of-sale`
4. Railway will automatically detect it's a Laravel project

### Step 3: Add a Database

1. In your project, click "New" → "Database" → "Add MySQL"
2. Railway will automatically create a MySQL database
3. The database credentials will be automatically added to your environment

### Step 4: Set Environment Variables

Railway will auto-detect some variables, but you need to add:

**Required Variables:**
- `APP_NAME`: Triangle POS
- `APP_KEY`: (Generate one - see below)
- `APP_ENV`: production
- `APP_DEBUG`: false

**To generate APP_KEY locally:**
```bash
php artisan key:generate --show
```
Copy the output (it looks like: `base64:xxxxxxxxxxxxx`)

**Database variables are auto-set by Railway:**
- `DATABASE_URL` is automatically provided
- Or use individual vars: `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

### Step 5: Deploy!

1. Click "Deploy"
2. Wait 2-3 minutes for the build to complete
3. Railway will give you a public URL like: `https://your-app.up.railway.app`

## Post-Deployment

### Run Database Migrations

Railway should run migrations automatically (configured in Procfile), but if needed:

1. Go to your project in Railway
2. Click on your service
3. Go to "Settings" → "Variables"
4. Or use Railway CLI:
```bash
railway login
railway run php artisan migrate --force
```

### Seed Database (if needed)
```bash
railway run php artisan db:seed
```

## Important Notes

✅ **What's Included (FREE):**
- MySQL database
- Public URL
- Automatic deployments from GitHub
- SSL certificate
- $5/month credit (usually enough for small projects)

⚠️ **File Storage:**
- Railway has persistent storage, but it's better to use cloud storage (S3, Cloudinary) for production
- For testing, local storage will work

⚠️ **Free Tier Limits:**
- $5 credit per month
- If you exceed, the service will pause until next month
- For this POS app, it should be fine for testing/demo purposes

## Troubleshooting

### Build Fails
- Check Railway logs in the dashboard
- Make sure `composer.json` and `package.json` are valid

### 500 Error
- Ensure `APP_KEY` is set in environment variables
- Check database connection in Railway logs

### Database Connection Error
- Railway auto-sets `DATABASE_URL`
- Make sure your `config/database.php` can parse it
- Or use individual DB variables

## Sharing Your App

Once deployed, you'll get a URL like:
```
https://point-of-sale-production.up.railway.app
```

Just share this URL with your friend! 🎉

## Alternative: Railway CLI (Optional)

Install Railway CLI for easier management:
```bash
# Install
npm i -g @railway/cli

# Login
railway login

# Link to project
railway link

# View logs
railway logs

# Run commands
railway run php artisan migrate
```

## Cost Estimate

For a demo/testing POS app:
- **Cost**: FREE (within $5/month credit)
- **Usage**: ~$2-3/month for light usage
- Perfect for sharing with friends and testing!
