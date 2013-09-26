# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "ubuntu_12.04.3_amd64"
  config.vm.box_url = "http://nitron-vagrant.s3-website-us-east-1.amazonaws.com/vagrant_ubuntu_12.04.3_amd64_virtualbox.box"

  # config.vm.provision :shell, :path => "bootstrap.sh"

  config.vm.provision :shell, :inline => "apt-get -q update"
  config.vm.provision :shell, :path => "provision/mysql.sh"
  config.vm.provision :shell, :path => "provision/apache2.sh"
  config.vm.provision :shell, :path => "provision/php.sh"
  config.vm.provision :shell, :path => "provision/deploy.sh"

  config.vm.network :forwarded_port, guest: 80, host: 8082
  config.vm.network :forwarded_port, guest: 4080, host: 4080

   config.vm.provider :virtualbox do |vb|
     # Use VBoxManage to customize the VM. For example to change memory:
      vb.customize ["modifyvm", :id, "--memory", "1024"]
      vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
   end
end
