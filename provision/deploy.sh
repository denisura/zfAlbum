apt-get install -y git-core

a2dissite default
a2dissite default-ssl
rm -rf /var/www
mkdir -p /var/www
ln -fs /vagrant/public /var/www/frontend
ln -fs /vagrant/app /var/www/api

cp /vagrant/provision/conf/apache2/vhost/* /etc/apache2/sites-available/
a2ensite api
a2ensite frontend

service apache2 reload

rm -rf /vagrant/vendor
php composer.phar install

mysql -u root -e "CREATE DATABASE IF NOT EXISTS zfalbum;"
/vagrant/vendor/bin/doctrine-module orm:schema-tool:create
/vagrant/vendor/bin/doctrine-module orm:validate-schema
