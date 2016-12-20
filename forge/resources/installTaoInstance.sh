#!/usr/bin/env bash

if [ $# -eq 3 ]; then
    INSTANCE_NAME=$1
    RAW_COMPOSERJSON_URL=$2
else
    tput setaf 1; echo "Wrong command signature"
    tput setaf 3; echo "Expected usage: " $0 " INSTANCE_NAME COMPOSER_JSON_RAW_URL EXTENSIONS"
    exit 1
fi

# modify these lines according to your needs
INSTANCE_DIR=$HOME/Projects/package-tao-$INSTANCE_NAME
INSTANCE_DOMAIN=$INSTANCE_NAME.loc

mkdir -p $INSTANCE_DIR && cd $INSTANCE_DIR

! [ -f composer.json ] && wget $RAW_COMPOSERJSON_URL -O composer.json
! [ -f index.php ] && wget https://raw.githubusercontent.com/oat-sa/package-tao/develop/index.php -O index.php
! [ -f .htaccess ] && wget https://raw.githubusercontent.com/oat-sa/package-tao/develop/.htaccess -O .htaccess
! [ -f phpunit.xml ] && wget https://raw.githubusercontent.com/oat-sa/package-tao/develop/phpunit.xml -O phpunit.xml

mkdir -p config/
mkdir -p data/
mkdir --parents -p tests/bootstrap/

! [ -f "config/.htaccess" ] && wget https://raw.githubusercontent.com/oat-sa/package-tao/develop/config/.htaccess -O config/.htaccess
! [ -f "data/.htaccess" ] && wget https://raw.githubusercontent.com/oat-sa/package-tao/develop/data/.htaccess -O data/.htaccess
! [ -f "tests/bootstrap/bootstrap.php" ] && wget https://raw.githubusercontent.com/oat-sa/package-tao/develop/tests/bootstrap/bootstrap.php -O tests/bootstrap/bootstrap.php

composer install

sudo chmod -R 777 config/ data/ taoQtiItem/views/js/portableSharedLibraries/ tao/views/locales/

sudo -u www-data php tao/scripts/taoInstall.php \
 --db_driver pdo_mysql \
 --db_host localhost \
 --db_name tao$INSTANCE_NAME \
 --db_user root \
 --db_pass root \
 --module_url http://$INSTANCE_DOMAIN \
 --user_login admin \
 --user_pass AsdAsd987@ \
 --module_namespace "http://$INSTANCE_DOMAIN/$INSTANCE_NAME.rdf" \
 -e $3 #multiple extensions separated by comma

if [ $? -eq 0 ]
then
  sudo chmod -R 777 config/ data/ taoQtiItem/views/js/portableSharedLibraries/ tao/views/locales/

  tput setaf 2; echo "$INSTANCE_NAME successfully installed!"
  tput sgr0

  VHOST_FILE=/etc/apache2/sites-available/tao_$INSTANCE_NAME.conf
  if ! [ -f $VHOST_FILE ]
  then
    cat << EOF | sudo tee -a $VHOST_FILE

<VirtualHost *:80>
    ServerAdmin webmaster@$INSTANCE_DOMAIN
    ServerName $INSTANCE_DOMAIN
    ServerAlias www.$INSTANCE_DOMAIN

    DocumentRoot $INSTANCE_DIR

    <Directory $INSTANCE_DIR>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF

    if [ $? -eq 0 ]
      then
        sudo a2ensite tao_$INSTANCE_NAME.conf
        sudo service apache2 restart
        tput setaf 2; echo "Apache vhost successfully added!"
        tput sgr0

        echo "127.0.0.1 $INSTANCE_DOMAIN www.$INSTANCE_DOMAIN" | sudo tee -a /etc/hosts

        tput setaf 2; echo "New hosts entry successfully added!"

        exit 0
      else
        tput setaf 1; echo "Adding vhost failed" >&2
        exit 1
      fi
  fi
else
  tput setaf 1; echo "Install failed" >&2
  exit 1
fi

