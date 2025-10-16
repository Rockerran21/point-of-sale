# Docker Deployment Guide - Oracle Cloud

## ✅ Why Docker is Better

- **One command deployment** - Everything automated
- **Consistent environment** - Works everywhere
- **Easy updates** - Just rebuild and restart
- **Isolated** - Won't mess with system packages
- **Portable** - Move to any cloud provider easily

## 🚀 Quick Deployment (3 Steps)

### Step 1: Create Oracle Cloud VM

1. Go to https://cloud.oracle.com
2. Create Instance:
   - **Shape:** VM.Standard.A1.Flex (ARM)
   - **OCPUs:** 2
   - **Memory:** 12GB
   - **Image:** Ubuntu 22.04
   - **Public IP:** Yes
3. Download SSH key
4. Wait for instance to be ready

### Step 2: Install Docker on VM

```bash
# SSH into your VM
ssh -i your-key.pem ubuntu@YOUR_PUBLIC_IP

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Install Docker Compose
sudo apt update
sudo apt install -y docker-compose-plugin

# Add user to docker group
sudo usermod -aG docker ubuntu

# Logout and login again for group to take effect
exit

# SSH back in
ssh -i your-key.pem ubuntu@YOUR_PUBLIC_IP

# Verify installation
docker --version
docker compose version
```

### Step 3: Deploy Application

```bash
# Clone your repository
git clone https://github.com/Rockerran21/point-of-sale.git
cd point-of-sale

# Create .env file
cp .env.example .env

# Edit .env (set APP_KEY and database credentials)
nano .env
```

**Set these in .env:**
```env
APP_NAME="Triangle POS"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENERATE_THIS_LATER
APP_URL=http://YOUR_PUBLIC_IP

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=triangle_pos
DB_USERNAME=posuser
DB_PASSWORD=YourStrongPassword123!
DB_ROOT_PASSWORD=RootPassword123!
```

```bash
# Build and start containers
docker compose up -d --build

# Wait for database to be ready (30 seconds)
sleep 30

# Generate APP_KEY
docker compose exec app php artisan key:generate

# Run migrations
docker compose exec app php artisan migrate --seed

# Create storage link
docker compose exec app php artisan storage:link

# Optimize
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

# Check if everything is running
docker compose ps
```

### Step 4: Configure Oracle Cloud Firewall

1. Go to Oracle Console → Networking → VCN → Security Lists
2. Add Ingress Rule:
   - **Source:** 0.0.0.0/0
   - **Protocol:** TCP
   - **Port:** 80

```bash
# Also configure Ubuntu firewall
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

### Step 5: Access Your Application

Visit: `http://YOUR_PUBLIC_IP`

**Login:**
- Email: super.admin@test.com
- Password: 12345678

## 🎉 That's It!

Your application is now running in Docker with:
- ✅ Laravel app with Nginx + PHP-FPM
- ✅ MySQL database
- ✅ Persistent storage
- ✅ Auto-restart on failure
- ✅ **All in 5 commands!**

## 📦 Useful Docker Commands

### View Logs
```bash
# All logs
docker compose logs -f

# App logs only
docker compose logs -f app

# Database logs
docker compose logs -f db
```

### Restart Services
```bash
# Restart everything
docker compose restart

# Restart app only
docker compose restart app
```

### Stop/Start
```bash
# Stop all containers
docker compose down

# Start all containers
docker compose up -d

# Stop and remove everything (including volumes)
docker compose down -v
```

### Execute Commands in Container
```bash
# Run artisan commands
docker compose exec app php artisan cache:clear
docker compose exec app php artisan migrate

# Access MySQL
docker compose exec db mysql -u posuser -p triangle_pos

# Shell access
docker compose exec app bash
```

### Update Application
```bash
cd /home/ubuntu/point-of-sale

# Pull latest code
git pull origin main

# Rebuild and restart
docker compose down
docker compose up -d --build

# Run migrations
docker compose exec app php artisan migrate --force

# Clear caches
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:cache
```

### Backup Database
```bash
# Backup
docker compose exec db mysqldump -u posuser -pYourPassword triangle_pos > backup.sql

# Restore
docker compose exec -T db mysql -u posuser -pYourPassword triangle_pos < backup.sql
```

## 🔧 Troubleshooting

### Container won't start
```bash
# Check logs
docker compose logs app

# Check if ports are in use
sudo netstat -tulpn | grep :80
```

### Database connection error
```bash
# Check if database is healthy
docker compose ps

# Restart database
docker compose restart db

# Wait 30 seconds and try again
```

### Permission errors
```bash
# Fix permissions
docker compose exec app chown -R www-data:www-data /var/www/html/storage
docker compose exec app chmod -R 775 /var/www/html/storage
```

### Out of memory
```bash
# Check memory usage
docker stats

# Reduce MySQL memory in docker-compose.yaml
# Add under db service:
#   command: --innodb-buffer-pool-size=256M
```

## 🎯 Production Tips

1. **Change default passwords** in .env
2. **Setup SSL** with Let's Encrypt (if you have a domain)
3. **Regular backups** - automate database dumps
4. **Monitor logs** - check for errors regularly
5. **Update regularly** - pull latest code and rebuild

## 💰 Cost

**Oracle Cloud Free Tier:**
- VM: FREE (forever)
- Storage: FREE (up to 200GB)
- Bandwidth: FREE (10TB/month)
- **Total: $0/month** 🎉

## Summary

Docker deployment is:
- ✅ **Faster** - 5 commands vs 50+
- ✅ **Easier** - No manual package installation
- ✅ **Safer** - Isolated environment
- ✅ **Portable** - Works on any cloud
- ✅ **Maintainable** - Easy updates

**You're done!** Your POS system is running on Oracle Cloud for FREE! 🚀
