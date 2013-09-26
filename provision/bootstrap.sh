#!/usr/bin/env bash

apt-get update
apt-get install linux-image-extra-`uname -r` dkms -y;
sudo sh -c "curl http://get.docker.io/gpg | apt-key add -";
sudo sh -c "echo deb https://get.docker.io/ubuntu docker main > /etc/apt/sources.list.d/docker.list";
apt-get update
apt-get install -q -y --force-yes lxc-docker;