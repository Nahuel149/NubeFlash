# NubeFlash Deployment Guide

This document outlines the complete process of deploying the NubeFlash application on AWS EC2 with an RDS database and configuring domain name and SSL.

## 1. EC2 Instance Setup

### Launch an EC2 Instance
- Amazon Linux 2
- t2.micro (free tier eligible)
- Security groups:
  - SSH (port 22)
  - HTTP (port 80)
  - HTTPS (port 443)
  - MySQL (port 3306)

### Connect to EC2 Instance
```bash
chmod 400 nubeflash.pem
ssh -i nubeflash.pem ec2-user@107.22.52.56
```

## 2. Install Required Packages

### PHP 7.3 and Apache
```bash
sudo amazon-linux-extras install php7.3 -y
sudo yum install httpd php-mysqlnd php-mbstring php-xml php-json -y
sudo systemctl enable httpd
sudo systemctl start httpd
```

### Git
```bash
sudo yum install git -y
```

### MySQL Client
```bash
sudo yum install mysql -y
```

### Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

## 3. Web Directory Setup
```bash
sudo mkdir -p /var/www/html
sudo chown -R ec2-user:ec2-user /var/www/html
```

## 4. Clone Repository
For public repositories:
```bash
cd /var/www/html
git clone https://github.com/Nahuel149/NubeFlash.git .
```

For private repositories:
```bash
cd /var/www/html
git clone https://[YOUR_TOKEN]@github.com/Nahuel149/NubeFlash.git .
```

## 5. Set File Permissions
```bash
sudo chmod -R 755 /var/www/html/
sudo chmod -R 777 /var/www/html/uploads/
sudo chmod -R 777 /var/www/html/application/logs/
sudo chmod -R 777 /var/www/html/application/cache/
sudo mkdir -p /var/www/html/application/sessions
sudo chmod -R 777 /var/www/html/application/sessions
```

## 6. Apache Configuration

Create a virtual host configuration:
```bash
sudo nano /etc/httpd/conf.d/nubeflash.conf
```

Add the following configuration:
```apache
# Configuration for the domain
<VirtualHost *:80>
    ServerName nubeflash.com
    ServerAlias www.nubeflash.com
    DocumentRoot /var/www/html

    <Directory /var/www/html>
        AllowOverride All
        Require all granted
    </Directory>

    # Allow Let's Encrypt verification
    <Directory "/var/www/html/.well-known/acme-challenge">
        Options None
        AllowOverride None
        Require all granted
    </Directory>

    ErrorLog /var/log/httpd/nubeflash_error.log
    CustomLog /var/log/httpd/nubeflash_access.log combined
</VirtualHost>

# Configuration for the EC2 hostname
<VirtualHost *:80>
    ServerName ec2-107-22-52-56.compute-1.amazonaws.com
    DocumentRoot /var/www/html

    <Directory /var/www/html>
        AllowOverride All
        Require all granted
    </Directory>

    # Allow Let's Encrypt verification
    <Directory "/var/www/html/.well-known/acme-challenge">
        Options None
        AllowOverride None
        Require all granted
    </Directory>

    ErrorLog /var/log/httpd/ec2_error.log
    CustomLog /var/log/httpd/ec2_access.log combined
</VirtualHost>

# Configuration for direct IP access
<VirtualHost *:80>
    ServerName 107.22.52.56
    DocumentRoot /var/www/html
    
    <Directory /var/www/html>
        AllowOverride All
        Require all granted
    </Directory>
    
    # Allow Let's Encrypt verification
    <Directory "/var/www/html/.well-known/acme-challenge">
        Options None
        AllowOverride None
        Require all granted
    </Directory>
    
    ErrorLog /var/log/httpd/ip_error.log
    CustomLog /var/log/httpd/ip_access.log combined
</VirtualHost>
```

Restart Apache:
```bash
sudo systemctl restart httpd
```

## 7. RDS Database Setup

### Create an RDS Instance
- Go to AWS Console → RDS → Create database
- Choose MySQL (8.0.40)
- Select "Standard create"
- Instance Identifier: nubeflash
- Set credentials: Username: admin, Password: nubeflash1
- Choose appropriate size (t2.micro for testing)
- Configure VPC, subnet, and security group settings
- Create database

### Create Schema and Import Data
```bash
# Create the database
mysql -h nubeflash.c2pwqx3crq7t.us-east-1.rds.amazonaws.com -u admin -pnubeflash1 -e "CREATE DATABASE lanube_api CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"

# Import database schema
mysql -h nubeflash.c2pwqx3crq7t.us-east-1.rds.amazonaws.com -u admin -pnubeflash1 lanube_api < /var/www/html/create_database.sql

# Import test data
mysql -h nubeflash.c2pwqx3crq7t.us-east-1.rds.amazonaws.com -u admin -pnubeflash1 lanube_api < /var/www/html/insert_test_data.sql
```

## 8. Application Configuration

### Database Configuration
Edit the database configuration file:
```bash
nano /var/www/html/application/config/database.php
```

Update with RDS connection details:
```php
$active_group = 'production';

$db['production'] = array(
    'dsn'      => '',
    'hostname' => 'nubeflash.c2pwqx3crq7t.us-east-1.rds.amazonaws.com',
    'username' => 'admin',
    'password' => 'nubeflash1',
    'database' => 'lanube_api',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => FALSE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => FALSE,
    'port'     => '3306'
);
```

### Base URL Configuration
Edit the config.php file:
```bash
nano /var/www/html/application/config/config.php
```

Update the base URL to be dynamic:
```php
// Dynamic detection of protocol and hostname
$protocol = 'http';
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $protocol = 'https';
} elseif (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] == 1)) {
    $protocol = 'https';
} elseif (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) {
    $protocol = 'https';
}

$config['base_url'] = $protocol . "://" . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'nubeflash.com');
```

## 9. DNS Configuration (Route 53)

### Create a Hosted Zone
- Go to AWS Console → Route 53 → Hosted zones → Create hosted zone
- Domain name: nubeflash.com
- Type: Public hosted zone
- Create hosted zone

### Create DNS Records
- Create an A record for nubeflash.com pointing to 107.22.52.56
- Create an A record for www.nubeflash.com pointing to 107.22.52.56

### Update Domain Registrar Nameservers
If your domain is registered outside of AWS, update the nameservers at your registrar to use Route 53's nameservers:
- ns-1533.awsdns-63.org
- ns-1594.awsdns-07.co.uk
- ns-221.awsdns-27.com
- ns-903.awsdns-48.net

## 10. SSL Configuration with Let's Encrypt

### Install EPEL repository and Certbot
```bash
sudo amazon-linux-extras install epel -y
sudo yum install -y certbot python-certbot-apache
```

### Create self-signed certificate (temporary)
```bash
sudo mkdir -p /etc/pki/tls/certs
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/pki/tls/private/localhost.key -out /etc/pki/tls/certs/localhost.crt -subj "/CN=localhost"
```

### Configure ACME challenge directory
```bash
sudo mkdir -p /var/www/html/.well-known/acme-challenge
sudo chmod -R 755 /var/www/html/.well-known
sudo chown -R apache:apache /var/www/html/.well-known
```

### Obtain SSL certificate
Wait for DNS propagation, then run:
```bash
sudo certbot --apache -d nubeflash.com -d www.nubeflash.com
```

Follow the prompts to provide an email address and agree to terms.

## 11. Troubleshooting

### DNS Troubleshooting
Check DNS propagation:
```bash
dig nubeflash.com @8.8.8.8 +short
nslookup nubeflash.com 8.8.8.8
```

For DNS issues, consider:
- Check Route 53 A records are pointing to your EC2 IP
- Verify nameservers are correctly set at your domain registrar
- Use online DNS propagation checkers like dnschecker.org

### SSL Troubleshooting
For SSL certificate issues:
- Check Apache error logs: `sudo cat /var/log/httpd/error_log`
- Verify DNS is resolving to your EC2 IP
- Check security groups allow HTTP/HTTPS traffic
- Test ACME challenge directory: `curl -I http://nubeflash.com/.well-known/acme-challenge/test`

If DNS validation fails, try the manual DNS validation method:
```bash
sudo certbot --apache --manual --preferred-challenges dns -d nubeflash.com -d www.nubeflash.com
```

## 12. Updating the Application

When there are new updates on GitHub, follow these steps to update your deployment:

### 1. Connect to EC2
```bash
ssh -i nubeflash.pem ec2-user@107.22.52.56
```

### 2. Backup Current Application (Optional)
```bash
cd /var/www
sudo tar -czvf html_backup_$(date +"%Y%m%d").tar.gz html/
```

### 3. Update Code from GitHub
If you've made no local changes:
```bash
cd /var/www/html
git pull origin main  # or master, or whatever branch you're using
```

If local changes exist that you want to discard:
```bash
cd /var/www/html
git fetch --all
git reset --hard origin/main  # or master, or whatever branch
```

If you need to completely refresh the codebase:
```bash
cd /var/www
sudo rm -rf html/*
cd html
git clone https://github.com/Nahuel149/NubeFlash.git .  # Or with token for private repos
```

### 4. Update Dependencies
If Composer dependencies have changed:
```bash
cd /var/www/html
composer update
```

### 5. Update Database
If there are database changes:
```bash
mysql -h nubeflash.c2pwqx3crq7t.us-east-1.rds.amazonaws.com -u admin -pnubeflash1 lanube_api < update_script.sql
```

Or for CodeIgniter migrations:
```bash
php index.php migrate
```

### 6. Reset Permissions
```bash
sudo chmod -R 755 /var/www/html/
sudo chmod -R 777 /var/www/html/uploads/
sudo chmod -R 777 /var/www/html/application/logs/
sudo chmod -R 777 /var/www/html/application/cache/
sudo chmod -R 777 /var/www/html/application/sessions
```

### 7. Clear Cache
```bash
sudo rm -rf /var/www/html/application/cache/*
```

### 8. Restart Apache
```bash
sudo systemctl restart httpd
```

## 13. Maintenance Best Practices

### Regular Backups
- Back up the database regularly
- Consider AWS snapshots for RDS
- Back up the application code

### System Updates
```bash
sudo yum update -y
```

### Security Best Practices
- Use HTTPS exclusively
- Keep software updated
- Implement proper access controls
- Consider AWS Web Application Firewall (WAF)
- Monitor logs for suspicious activity

### Performance Monitoring
- Set up CloudWatch for performance monitoring
- Check Apache access logs for traffic patterns
- Monitor RDS performance metrics

## Resources
- [Apache HTTP Server Documentation](https://httpd.apache.org/docs/)
- [CodeIgniter 3 Documentation](https://codeigniter.com/userguide3/)
- [Let's Encrypt Documentation](https://letsencrypt.org/docs/)
- [AWS Documentation](https://docs.aws.amazon.com/)