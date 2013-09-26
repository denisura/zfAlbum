#!/usr/bin/env bash

add-apt-repository ppa:ondrej/php5-oldstable
apt-get update
# apt-get upgrade

apt-get install -qq -y  \
                   php5 \
                   php5-mysql \
                   php5-xdebug \
                   curl libcurl3 libcurl3-dev php5-curl \
                   php5-xsl \
                   php5-sqlite \
                   php5-intl \
                   php-apc \
                   php5-gd

sed -i "s:^;*date.timezone =.*:date.timezone = UTC:g" /etc/php5/cli/php.ini
sed -i "s:^;*short_open_tag = .*:short_open_tag = Off:g" /etc/php5/cli/php.ini