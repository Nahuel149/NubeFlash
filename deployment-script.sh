#!/bin/bash

# NubeFlash Deployment Script - Server Configuration Phase
# ----------------------------------------------------------

echo "===== Starting NubeFlash Server Configuration ====="
echo "Current time: $(date)"
echo ""

# 1. Initial Server Setup
# -----------------------
echo "Step 1: Updating system packages..."
sudo yum update -y

echo "Step 2: Setting timezone to Argentina/Buenos_Aires..."
sudo timedatectl set-timezone America/Argentina/Buenos_Aires
echo "Current timezone: $(timedatectl | grep "Time zone")"

# 2. Install MariaDB (Required for NubeFlash)
# -------------------------------------------
echo "Step 3: Installing MariaDB..."
sudo yum install mariadb-server -y

echo "Step 4: Starting and enabling MariaDB..."
sudo systemctl start mariadb
sudo systemctl enable mariadb
echo "MariaDB status: $(systemctl is-active mariadb)"

echo "Step 5: Securing MariaDB installation..."
echo "NOTE: You will be prompted to set a root password and secure your installation"
echo "When prompted, we recommend:"
echo "- Set root password: Y"
echo "- Remove anonymous users: Y"
echo "- Disallow root login remotely: Y"
echo "- Remove test database: Y"
echo "- Reload privilege tables: Y"
echo "Press Enter to continue..."
read
sudo mysql_secure_installation

echo "Step 6: Creating database and user for NubeFlash..."
echo "You'll need to enter the MariaDB root password you just set"
echo "Creating database 'lanube_api' and user 'lanubeflash' with password 'lanubeflash1'"
echo "Press Enter to continue..."
read
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS lanube_api; CREATE USER IF NOT EXISTS 'lanubeflash'@'localhost' IDENTIFIED BY 'lanubeflash1'; GRANT ALL PRIVILEGES ON lanube_api.* TO 'lanubeflash'@'localhost'; FLUSH PRIVILEGES;"

# 3. Install PHP 7.3.33 (Required for NubeFlash)
# ----------------------------------------------
echo "Step 7: Installing PHP 7.3.33 and required extensions..."
sudo amazon-linux-extras enable php7.3
sudo yum clean metadata
sudo yum install -y php php-cli php-common php-fpm php-gd php-json php-mbstring php-mysqlnd php-pdo php-xml php-zip php-intl
echo "PHP version: $(php -v | head -n 1)"

# 4. Install Required Software
# ---------------------------
echo "Step 8: Installing Apache..."
sudo yum install -y httpd

echo "Step 9: Starting and enabling Apache..."
sudo systemctl start httpd
sudo systemctl enable httpd
echo "Apache status: $(systemctl is-active httpd)"

echo "Step 10: Installing Git..."
sudo yum install -y git
echo "Git version: $(git --version)"

echo "Step 11: Installing Composer..."
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
echo "Composer version: $(composer --version)"

# 5. Configure Web Server
# ----------------------
echo "Step 12: Creating virtual host configuration..."
sudo tee /etc/httpd/conf.d/nubeflash.conf > /dev/null << EOF
<VirtualHost *:80>
    ServerName ec2-52-55-9-170.compute-1.amazonaws.com
    ServerAlias 52.55.9.170
    DocumentRoot /var/www/html/nubeflash

    <Directory /var/www/html/nubeflash>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog /var/log/httpd/nubeflash-error.log
    CustomLog /var/log/httpd/nubeflash-access.log combined
</VirtualHost>
EOF

echo "Step 13: Restarting Apache to apply changes..."
sudo systemctl restart httpd

# 6. Prepare Application Directories
# --------------------------------
echo "Step 14: Creating web directories..."
sudo mkdir -p /var/www/html/nubeflash
sudo chmod 755 /var/www/html/nubeflash

echo "Step 15: Creating application directories..."
sudo mkdir -p /var/www/html/nubeflash/application/logs/backend
sudo mkdir -p /var/www/html/nubeflash/application/cache
sudo mkdir -p /var/www/html/nubeflash/application/sessions
sudo mkdir -p /var/www/html/nubeflash/uploads/zip

echo "Step 16: Setting proper permissions..."
sudo chown -R apache:apache /var/www/html/nubeflash
sudo chmod -R 755 /var/www/html/nubeflash/application/logs
sudo chmod -R 755 /var/www/html/nubeflash/application/cache
sudo chmod -R 755 /var/www/html/nubeflash/application/sessions
sudo chmod -R 755 /var/www/html/nubeflash/uploads

# 7. Test Configuration
# --------------------
echo "Step 17: Testing Apache configuration..."
sudo apachectl configtest

echo "Step 18: Creating a test PHP file..."
echo "<?php phpinfo(); ?>" | sudo tee /var/www/html/nubeflash/info.php

echo "Step 19: Configuring firewall..."
if sudo systemctl is-active --quiet firewalld; then
    sudo firewall-cmd --permanent --add-service=http
    sudo firewall-cmd --permanent --add-service=https
    sudo firewall-cmd --reload
    echo "Firewall configured to allow HTTP and HTTPS"
else
    echo "Firewall service (firewalld) is not active, skipping firewall configuration"
fi

# 8. Summary and Next Steps
# ------------------------
echo ""
echo "===== NubeFlash Server Configuration Completed ====="
echo "MariaDB Status: $(systemctl is-active mariadb)"
echo "Apache Status: $(systemctl is-active httpd)"
echo "PHP Version: $(php -v | head -n 1)"
echo "Configured Server URL: http://52.55.9.170"
echo "PHP Info Page: http://52.55.9.170/nubeflash/info.php"
echo ""
echo "Next steps:"
echo "1. Deploy application code to /var/www/html/nubeflash"
echo "2. Import database schema using create_database.sql and insert_test_data.sql"
echo "3. Configure application settings"
echo ""
echo "Completed at: $(date)" 