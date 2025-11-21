# Deployment Guide
## Production Setup for Premium Bikes Marketplace

**Version:** 1.0  
**Date:** 2024

---

## 📋 Table of Contents

1. [Server Requirements](#server-requirements)
2. [Initial Server Setup](#initial-server-setup)
3. [Application Deployment](#application-deployment)
4. [SSL Configuration](#ssl-configuration)
5. [Queue Workers](#queue-workers)
6. [Monitoring Setup](#monitoring-setup)
7. [Backup Procedures](#backup-procedures)
8. [Troubleshooting](#troubleshooting)

---

## Server Requirements

### Minimum Specifications

- **OS**: Ubuntu 22.04 LTS
- **RAM**: 4GB (8GB recommended)
- **CPU**: 2 cores (4 cores recommended)
- **Storage**: 50GB SSD
- **PHP**: 8.2+
- **MySQL**: 8.0+
- **Redis**: Latest stable
- **Nginx**: Latest stable

---

## Initial Server Setup

### 1. Update System

```bash
sudo apt update && sudo apt upgrade -y
```

### 2. Install Required Software

```bash
# Install PHP 8.2 and extensions
sudo apt install -y php8.2-fpm php8.2-cli php8.2-mysql php8.2-xml \
    php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-redis \
    php8.2-bcmath php8.2-intl

# Install MySQL
sudo apt install -y mysql-server

# Install Redis
sudo apt install -y redis-server

# Install Nginx
sudo apt install -y nginx

# Install Supervisor
sudo apt install -y supervisor

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js and NPM
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

### 3. Configure MySQL

```bash
sudo mysql_secure_installation

# Create database and user
sudo mysql -u root -p
```

```sql
CREATE DATABASE premium_bikes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'premium_bikes'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON premium_bikes.* TO 'premium_bikes'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4. Configure Redis

```bash
sudo nano /etc/redis/redis.conf
```

Uncomment and set:
```
bind 127.0.0.1
```

Restart Redis:
```bash
sudo systemctl restart redis-server
sudo systemctl enable redis-server
```

---

## Application Deployment

### 1. Clone Repository

```bash
cd /var/www
sudo git clone https://github.com/yourusername/premium-bikes.git
sudo chown -R www-data:www-data premium-bikes
cd premium-bikes
```

### 2. Install Dependencies

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

### 3. Environment Configuration

```bash
cp .env.example .env
nano .env
```

Configure:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=premium_bikes
DB_USERNAME=premium_bikes
DB_PASSWORD=your_password

CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

```bash
php artisan migrate --force
php artisan db:seed --force
```

### 6. Create Storage Link

```bash
php artisan storage:link
```

### 7. Set Permissions

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 8. Optimize Application

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize
```

---

## SSL Configuration

### Using Let's Encrypt (Certbot)

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

Certbot will automatically configure Nginx and renew certificates.

### Manual SSL Configuration

See Nginx configuration in main README.md

---

## Queue Workers

### Supervisor Configuration

Create file: `/etc/supervisor/conf.d/premium-bikes-worker.conf`

```ini
[program:premium-bikes-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/premium-bikes/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/premium-bikes/storage/logs/worker.log
stopwaitsecs=3600
```

### Start Supervisor

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start premium-bikes-worker:*
```

---

## Monitoring Setup

### 1. Laravel Telescope (Development)

```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

### 2. Sentry Error Tracking

```bash
composer require sentry/sentry-laravel
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"
```

Add to `.env`:
```env
SENTRY_LARAVEL_DSN=your_sentry_dsn
SENTRY_TRACES_SAMPLE_RATE=0.2
```

### 3. Uptime Monitoring

Set up UptimeRobot or similar service to monitor:
- `https://yourdomain.com/up` (health check)
- Main application URL

---

## Backup Procedures

### Database Backup Script

Create: `/usr/local/bin/backup-premium-bikes.sh`

```bash
#!/bin/bash
BACKUP_DIR="/var/backups/premium-bikes"
DATE=$(date +%Y%m%d_%H%M%S)
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u premium_bikes -p'your_password' premium_bikes | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Files backup
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/premium-bikes/storage

# Keep only last 30 days
find $BACKUP_DIR -type f -mtime +30 -delete
```

Make executable:
```bash
sudo chmod +x /usr/local/bin/backup-premium-bikes.sh
```

### Cron Job for Automated Backups

```bash
sudo crontab -e
```

Add:
```
0 2 * * * /usr/local/bin/backup-premium-bikes.sh
```

---

## Troubleshooting

### Check Logs

```bash
# Application logs
tail -f /var/www/premium-bikes/storage/logs/laravel.log

# Nginx logs
tail -f /var/log/nginx/error.log
tail -f /var/log/nginx/access.log

# PHP-FPM logs
tail -f /var/log/php8.2-fpm.log

# Queue worker logs
tail -f /var/www/premium-bikes/storage/logs/worker.log
```

### Common Issues

#### 500 Error
- Check file permissions
- Check `.env` configuration
- Check PHP-FPM status: `sudo systemctl status php8.2-fpm`

#### Queue Not Processing
- Check Supervisor: `sudo supervisorctl status`
- Restart workers: `sudo supervisorctl restart premium-bikes-worker:*`

#### Cache Issues
- Clear cache: `php artisan cache:clear`
- Clear config: `php artisan config:clear`

#### Database Connection
- Verify MySQL is running: `sudo systemctl status mysql`
- Test connection: `mysql -u premium_bikes -p premium_bikes`

---

## Deployment Checklist

- [ ] Server provisioned and updated
- [ ] All software installed
- [ ] Database created and configured
- [ ] Application cloned and configured
- [ ] Environment variables set
- [ ] Migrations run
- [ ] Storage link created
- [ ] Permissions set correctly
- [ ] SSL certificate installed
- [ ] Nginx configured
- [ ] Queue workers running
- [ ] Monitoring set up
- [ ] Backups configured
- [ ] Health check passing
- [ ] All tests passing

---

**Last Updated**: 2024

