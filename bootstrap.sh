#!/usr/bin/env bash

#Variaveis
DBPASSWD=vagrant


echo -e "\n--- Isto vai demorar...  Vai tomar um café! ---\n"

echo -e "\n--- Updating System...  ---\n"
sudo apt-get update > /dev/null 2>&1


echo -e "\n--- Installing Git ---\n"
sudo apt-get -y install git > /dev/null 2>&1

echo -e "\n--- Installing Apache ---\n"
sudo apt-get -y install apache2 > /dev/null 2>&1


echo -e "\n--- Installing PHP ---\n"
sudo apt-get -y installing php5 libapache2-mod-php5 > /dev/null 2>&1

echo -e "\n--- Installing MySQL specific packages and settings ---\n"
echo "mysql-server mysql-server/root_password password $DBPASSWD" | debconf-set-selections
echo "mysql-server mysql-server/root_password_again password $DBPASSWD" | debconf-set-selections
echo "phpmyadmin phpmyadmin/dbconfig-install boolean true" | debconf-set-selections
echo "phpmyadmin phpmyadmin/app-password-confirm password $DBPASSWD" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/admin-pass password $DBPASSWD" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/app-pass password $DBPASSWD" | debconf-set-selections
echo "phpmyadmin phpmyadmin/reconfigure-webserver multiselect none" | debconf-set-selections
sudo apt-get -y install mysql-server-5.5 phpmyadmin > /dev/null 2>&1
sudo apt-get -y install php5-mysql php5-curl php5-gd php5-intl php-pear php5-imagick php5-imap php5-mcrypt php5-memcache php5-ming php5-ps php5-pspell php5-recode php5-sqlite php5-tidy php5-xmlrpc php5-xsl > /dev/null 2>&1

sudo a2enmod rewrite
sudo sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf

echo -e "\n--- Setting document root to public directory ---\n"

cat > /etc/apache2/sites-enabled/000-default.conf <<EOF
<VirtualHost *:80>
        # The ServerName directive sets the request scheme, hostname and port that
        # the server uses to identify itself. This is used when creating
        # redirection URLs. In the context of virtual hosts, the ServerName
        # specifies what hostname must appear in the request's Host: header to
        # match this virtual host. For the default virtual host (this file) this
        # value is not decisive as it is used as a last resort host regardless.
        # However, you must set it for any further virtual host explicitly.
        #ServerName www.example.com

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www

        # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
        # error, crit, alert, emerg.
        # It is also possible to configure the loglevel for particular
        # modules, e.g.
        #LogLevel info ssl:warn

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        # For most configuration files from conf-available/, which are
        # enabled or disabled at a global level, it is possible to
        # include a line for only one particular virtual host. For example the
        # following line enables the CGI configuration for this host only
        # after it has been globally disabled with "a2disconf".
        #Include conf-available/serve-cgi-bin.conf
</VirtualHost>

EOF

sudo rm -rf /var/www
sudo ln -fs /vagrant/yii2-app/web /var/www

sudo service apache2 reload

echo -e "Installing composer...\n"
cd /
sudo mkdir download
cd download
sudo wget https://getcomposer.org/installer
sudo mv installer composer-setup.php
sudo php composer-setup.php --version=1.4.1
sudo mv composer.phar /usr/local/bin/composer
sudo  chmod 0700 /usr/local/bin/composer

composer global require "fxp/composer-asset-plugin:1.2.0"
echo -e "Installing dependencies...\n"
cd /vagrant/yii2-app
sudo chmod 0700 ./yii
composer install


echo -e "\n--- All done! ---\n"
echo -e "\n--- IP : 192.168.70.100 Login : admin Password : admin ---\n"



