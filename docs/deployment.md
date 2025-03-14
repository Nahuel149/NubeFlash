# NubeFlash - AWS Deployment Guide

This guide provides step-by-step instructions for deploying NubeFlash to AWS for production use.

## Table of Contents

1. [Infrastructure Setup](#infrastructure-setup)
2. [Server Configuration](#server-configuration)
3. [Application Deployment](#application-deployment)
4. [Security Configuration](#security-configuration)
5. [Monitoring & Scaling](#monitoring--scaling)
6. [Pre-deployment Verification](#pre-deployment-verification)
7. [Post-deployment Tasks](#post-deployment-tasks)
8. [Troubleshooting](#troubleshooting)

## Infrastructure Setup

### EC2 Instance Setup

## Detailed PHP 7.3.33 Setup Guide

This section provides detailed instructions for setting up NubeFlash on Amazon Linux 2 with PHP 7.3.33, which is the version the application was originally developed for.

### 1. Selecting the Right AMI

When creating your EC2 instance, select the following AMI:
- **AMI**: Amazon Linux 2 AMI (HVM) - Kernel 5.10, SSD Volume Type (ami-0a40094c716b52a2)
- **Type**: t3.small or larger (2GB RAM minimum)
- **Storage**: 20GB gp2 (minimum)

> **IMPORTANT NOTE**: Do not use Amazon Linux 2023 for this deployment. Amazon Linux 2023 does not support PHP 7.3.33 in its repositories, and attempts to install PHP 7.3.33 on it will result in compatibility errors. The application was developed for PHP 7.3.33, and using newer PHP versions (8.x) may cause deprecation warnings and functionality issues.

### 2. Initial Server Setup

#### Connect to your instance
```bash
ssh -i your-key.pem ec2-user@your-elastic-ip
```

#### Update system packages
```bash
sudo yum update -y
```

#### Set time zone
```bash
sudo timedatectl set-timezone America/Argentina/Buenos_Aires
```

### 3. Database Setup (MariaDB)

#### Install MariaDB
```bash
sudo yum install mariadb-server -y
```

#### Start and enable MariaDB
```bash
sudo systemctl start mariadb
sudo systemctl enable mariadb
```

#### Secure MariaDB installation
```bash
sudo mysql_secure_installation
```
- Follow the prompts to set a root password and secure your installation

#### Create database and user
```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE lanube_api;
CREATE USER 'lanubeflash'@'localhost' IDENTIFIED BY 'lanubeflash1';
GRANT ALL PRIVILEGES ON lanube_api.* TO 'lanubeflash'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4. PHP 7.3.33 Installation

Amazon Linux 2 allows installing PHP 7.3.33 easily via the amazon-linux-extras repository.

#### Install PHP 7.3.33 and required extensions
```bash
sudo amazon-linux-extras enable php7.3
sudo yum clean metadata
sudo yum install -y php php-cli php-common php-fpm php-gd php-json php-mbstring php-mysqlnd php-pdo php-xml php-zip php-intl
```

#### Verify PHP version
```bash
php -v
```
You should see PHP 7.3.33 as the output.

#### Configure PHP Sessions Directory
```bash
sudo mkdir -p /var/www/html/nubeflash/application/sessions
sudo chown -R apache:apache /var/www/html/nubeflash/application/sessions
sudo chmod -R 755 /var/www/html/nubeflash/application/sessions
```

#### Configure PHP-FPM (if using)
```bash
sudo systemctl start php-fpm
sudo systemctl enable php-fpm
```

### 5. Apache Installation and Configuration

#### Install Apache
```bash
sudo yum install httpd -y
```

#### Create Virtual Host for NubeFlash
```bash
sudo nano /etc/httpd/conf.d/nubeflash.conf
```

Add the following configuration:
```apache
<VirtualHost *:80>
    ServerName ec2-your-ip.compute-1.amazonaws.com
    ServerAlias your-ip
    DocumentRoot /var/www/html/nubeflash

    <Directory /var/www/html/nubeflash>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog /var/log/httpd/nubeflash-error.log
    CustomLog /var/log/httpd/nubeflash-access.log combined
</VirtualHost>
```

#### Start and enable Apache
```bash
sudo systemctl start httpd
sudo systemctl enable httpd
```

### 6. Application Deployment

#### Install Git
```bash
sudo yum install -y git
```

#### Clone repository
```bash
cd /tmp
git clone https://github.com/Nahuel149/NubeFlash.git
sudo mkdir -p /var/www/html/nubeflash
sudo cp -r NubeFlash/* /var/www/html/nubeflash/
sudo cp -r NubeFlash/.git /var/www/html/nubeflash/
```

#### Set file permissions
```bash
sudo chown -R apache:apache /var/www/html/nubeflash
sudo chmod -R 755 /var/www/html/nubeflash
```

#### Create required directories
```bash
sudo mkdir -p /var/www/html/nubeflash/application/logs/backend
sudo mkdir -p /var/www/html/nubeflash/application/cache
sudo mkdir -p /var/www/html/nubeflash/uploads/zip
sudo chmod -R 755 /var/www/html/nubeflash/application/logs
sudo chmod -R 755 /var/www/html/nubeflash/application/cache
sudo chmod -R 755 /var/www/html/nubeflash/uploads
sudo chown -R apache:apache /var/www/html/nubeflash/application/logs
sudo chown -R apache:apache /var/www/html/nubeflash/application/cache
sudo chown -R apache:apache /var/www/html/nubeflash/uploads
```

#### Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

#### Install PHP dependencies
```bash
cd /var/www/html/nubeflash
sudo -u apache composer install --no-dev --optimize-autoloader
```

### 7. CodeIgniter Configuration

#### Database Configuration
Edit the database configuration file to use the correct credentials:
```bash
sudo nano /var/www/html/nubeflash/application/config/database.php
```

Ensure it contains:
```php
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',
    'username' => 'lanubeflash',
    'password' => 'lanubeflash1',
    'database' => 'lanube_api',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => (ENVIRONMENT !== 'production'),
    'port'     => '3306'
);
```

#### Environment Configuration
Ensure the environment is set to production in the main index.php file:
```bash
sudo nano /var/www/html/nubeflash/index.php
```

Make sure it contains:
```php
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');
```

#### Import Database Schema and Data
```bash
mysql -u lanubeflash -p lanube_api < /var/www/html/nubeflash/create_database.sql
mysql -u lanubeflash -p lanube_api < /var/www/html/nubeflash/insert_test_data.sql
```

### 8. Security Configurations

#### Disable HTTPS Redirect in Development (Optional)
If you encounter issues with the application redirecting to HTTPS without SSL configured:

```bash
sudo cp /var/www/html/nubeflash/application/hooks/Security_hook.php /var/www/html/nubeflash/application/hooks/Security_hook.php.bak
sudo sed -i 's/if (ENVIRONMENT === .production./false/' /var/www/html/nubeflash/application/hooks/Security_hook.php
```

#### Properly Configure SSL for Production
For production, follow the SSL certificate setup instructions in the main deployment guide.

### 9. Final Steps

#### Restart all services
```bash
sudo systemctl restart mariadb
sudo systemctl restart php-fpm
sudo systemctl restart httpd
```

#### Test the application
Access your application at:
```
http://your-ip/nubeflash/
```

### 10. Troubleshooting PHP 7.3-Specific Issues

#### Check PHP Version
```bash
php -v
```

#### Verify PHP Modules
```bash
php -m
```

#### Check PHP Error Logs
```bash
sudo tail -f /var/log/php-fpm/www-error.log
```

#### Test PHP Configuration
```bash
echo '<?php phpinfo(); ?>' | sudo tee /var/www/html/info.php
```
Access http://your-ip/info.php to verify PHP configuration (remember to remove this file after testing).

#### Common PHP 7.3 Issues
1. **Missing extensions** - Check that all required extensions are installed:
   ```bash
   sudo yum install -y php-common php-mbstring php-xml php-json php-gd php-mysqli php-intl php-zip
   ```

2. **Memory limit issues** - Adjust PHP memory limit if needed:
   ```bash
   sudo nano /etc/php.ini
   ```
   Find and modify the memory_limit setting:
   ```
   memory_limit = 256M
   ```

3. **File upload issues** - Adjust upload settings if needed:
   ```
   upload_max_filesize = 64M
   post_max_size = 64M
   ```

### 11. Backup Recommendations

#### Database Backup
```bash
mysqldump -u lanubeflash -p lanube_api > /home/ec2-user/lanube_api_backup_$(date +%Y%m%d).sql
```

#### Create a Cronjob for Regular Backups
```bash
sudo nano /etc/crontab
```
Add the following for a daily backup at 2 AM:
```
0 2 * * * ec2-user mysqldump -u lanubeflash -p'lanubeflash1' lanube_api > /home/ec2-user/backups/lanube_api_backup_$(date +\%Y\%m\%d).sql
```

### 12. Migrating from an Existing Installation

This section provides instructions for cleaning up an existing EC2 instance while preserving the MariaDB database, and migrating to a new instance.

#### Cleaning Up an Existing Instance

If you need to clean up an existing instance while preserving the MariaDB database (useful for troubleshooting or redeployment), follow these steps:

```bash
# Stop Apache service
sudo systemctl stop httpd

# Remove Apache and PHP packages
sudo dnf remove httpd* php* -y

# Remove Apache configuration and application files
sudo rm -rf /etc/httpd /var/www/html/nubeflash

# Remove PHP configuration files
sudo rm -rf /etc/php*

# Remove any PHP source files if you compiled from source
sudo rm -rf /tmp/php-7.3.33 /tmp/php-7.3.33.tar.gz
sudo rm -rf /usr/local/php7.3
```

#### Verifying MariaDB is Still Running

After cleanup, verify that MariaDB is still running:

```bash
sudo systemctl status mariadb
```

You should see `active (running)` in the output.

#### Creating a Database Backup for Migration

Before migrating to a new instance, create a backup of your database:

```bash
# Create the backup
sudo mysqldump -u root lanube_api | sudo tee /home/ec2-user/lanube_api_backup.sql > /dev/null

# Set proper ownership
sudo chown ec2-user:ec2-user /home/ec2-user/lanube_api_backup.sql

# Verify the backup was created
ls -l /home/ec2-user/lanube_api_backup.sql
```

#### Downloading the Backup to Your Local Machine

Download the backup to your local machine for safekeeping:

```bash
# Run this from your local terminal, not the EC2 instance
scp -i your-key.pem ec2-user@your-instance-ip:/home/ec2-user/lanube_api_backup.sql .
```

#### Migrating to a New EC2 Instance

To migrate your database to a new EC2 instance:

1. Set up the new EC2 instance following the guide in this document
2. Install MariaDB on the new instance as described in section 3
3. Upload the backup file to the new instance:
   ```bash
   scp -i your-new-key.pem lanube_api_backup.sql ec2-user@new-instance-ip:/home/ec2-user/
   ```
4. Restore the database on the new instance:
   ```bash
   ssh -i your-new-key.pem ec2-user@new-instance-ip
   sudo mysql -e "CREATE DATABASE lanube_api;"
   sudo mysql -e "CREATE USER 'lanubeflash'@'localhost' IDENTIFIED BY 'lanubeflash1';"
   sudo mysql -e "GRANT ALL PRIVILEGES ON lanube_api.* TO 'lanubeflash'@'localhost';"
   sudo mysql -e "FLUSH PRIVILEGES;"
   sudo mysql lanube_api < /home/ec2-user/lanube_api_backup.sql
   ```
5. Complete the rest of the installation process (PHP, Apache, application deployment)

#### Alternative: Using Amazon RDS

For a more scalable and managed solution, consider using Amazon RDS for your database:

1. Create an Amazon RDS MariaDB instance in the AWS Management Console
2. Configure the security group to allow connections from your EC2 instance
3. Import your database backup to the RDS instance
4. Update your application's database configuration to connect to the RDS endpoint

Using RDS provides benefits like automated backups, easier scaling, and managed maintenance.

By following this detailed guide, you should be able to successfully deploy NubeFlash to an Amazon Linux 2 EC2 instance with PHP 7.3.33, which matches the application's original development environment.

---

This deployment guide should provide all the necessary steps to successfully deploy NubeFlash to AWS. If you encounter any issues during deployment, refer to the troubleshooting section or contact your system administrator.

**Last updated:** 2025-03-14 