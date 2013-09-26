#!/usr/bin/env bash

apt-get update
apt-get install -y -q apache2 \
                      libapache2-mod-php5 \
                      libapache2-mod-auth-mysql;

a2enmod ssl;
a2enmod headers;
a2enmod rewrite;
a2enmod php5;
echo 'ServerName localhost' > /etc/apache2/conf.d/fqdn;
cp /vagrant/provision/conf/apache2/ports.conf /etc/apache2/ports.conf




