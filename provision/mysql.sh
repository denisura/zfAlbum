#!/usr/bin/env bash

apt-get -y install python-software-properties
add-apt-repository -y ppa:ondrej/mysql
apt-get update
DEBIAN_FRONTEND=noninteractive apt-get -y install mysql-client-5.6 mysql-server-5.6

sleep 5
service mysql start
