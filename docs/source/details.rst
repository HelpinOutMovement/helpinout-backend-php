.. _chapter:details:

Detailed installation instructions
==================================

Detailed instructons for configuration of new server in AWS Mumbai region, running Ubuntu 18.04 LTS, with PHP 7.2, nginx. and AuroraDB.


Initial setup
=============

Server
------

Once the server is set up, log in using the key specified during the EC2 instance creation, normally *hio-infra.pem*::

  ssh -i HIO-infra.pem <server_IP_or_subdomain>

Installation
~~~~~~~~~~~~

Switch to using *aptitude* in preference to *apt-get*, and install some basicc packages::

  sudo apt-get update
  sudo apt-get install aptitude
  sudo aptitude update
  sudo aptitude safe-upgrade  # Reboot might be needed. If so, do now
  sudo aptitude install rsync mdadm zip unzip tmux bzip2

Add *admin* user the default user, *ubuntu*::

  sudo adduser admin --ingroup admin  # Respond to prompts
  sudo adduser admin admin

Make *sudo* password-less for *admin*. Edit */etc/sudoers.d/90-cloud-init-users*, and add the line::
  admin ALL=(ALL) NOPASSWD:ALL

Add a *~admin/.bash_aliases* file with some convenient aliases (this file is sourced automatically from *~/.bashrc*::
  alias ls='ls --color=auto'
  alias ll='ls -l'
  alias cd-='cd -'
  alias grep='grep --color=auto'
  alias wc='wc -l'
  alias bc='bc -l'
  alias h='history'

Add SSH keys to the *admin* account::
  sudo mkdir ~admin/.ssh
  sudo chmod 700 ~admin/.ssh
  sudo cp ~/.ssh/authorized_keys ~admin/.ssh
  sudo chmod 600 ~admin/.ssh/authorized_keys
  sudo chown -R admin.admin ~admin/.ssh

*ssh* in as user *admin*, and check privileges.

Add a *~webuser/.bash_aliases* file as above

Add SSH keys to the *webuser* account::
  sudo mkdir ~webuser/.ssh
  sudo chmod 700 ~webuser/.ssh
  sudo cp ~/.ssh/authorized_keys ~webuser/.ssh
  sudo chmod 600 ~webuser/.ssh/authorized_keys
  sudo chown -R webuser.webuser ~webuser/.ssh

Check that *webuser* can log in.


**With Ubuntu 18.04, this should alrady be done.** If not, edit */etc/ssh/sshd__config*. Uncomment the line for PasswordAuthentication, and change it from yes to no. It is advisable to keep an *admin* shell on the server open in a separate terminal in case something goes wrong. It should look like::
  PasswordAuthentication no

Verify that you are able to log in as both admin, and webuser

Change timezone to Asia/Kolkata. Easisest way is::
  sudo dpkg-reconfigure tzdata

Follow instructions, choosing Asia > Kolkata.

Change hostname to the appropriate sub-domain of mimirtech.com. E.g., for *www.mimirtech.com*::
  sudo hostname www.mimirtech.com

Edit */etc/hostname* and enter::
  www.mimirtech.com

Edit */etc/hosts* and have the first two lines as::
  127.0.0.1 localhost www.mimirtech.com
  ::1       www.taxspanner.com ip6-localhost ip6-loopback
    
Make hostname changes permanent::
  sudo systemctl restart systemd-logind.service

The new hostname will be in the shell prompt after logging out, and logging back in

Curreently there is only one webserver which provides  web services through *nginx*::
  sudo aptitude install nginx-full

Serve Django through port 8002 using uWSGI::
  sudo aptitude install uwsgi-emperor

Remove the *nginx* default configuration::
  sudo rm /etc/nginx/sites-enabled/default

From Ubuntu 18.04 onwards *nginx* is not enabled by default. Enable it::
  sudo systemctl enable nginx

Set up uWSGI::
  sudo mkdir -p /var/log/uwsgi/app/
  sudo chown -R www-data.www-data /var/log/uwsgi/app/
  sudo adduser admin www-data
  sudo adduser webuser www-data

Install some packages::
  sudo aptitude install mercurial python3.7 python3.7-dev python3.7-venv build-essential libcurl4-openssl-dev libffi-dev libxslt-dev libxml2-dev libmagic1 libtiff-dev libjpeg-dev zlib1g-dev libfreetype6-dev liblcms2-dev libwebp-dev libopenjp2-7-dev libpq-dev libxrender1 fontconfig xvfb xfonts-75dpi mercurial-keyring links pwgen


Install postfix on main webserver::
  sudo aptitude install postfix mailutils

Disk setup
----------

Besides the 10GB root drive, we set up the following:

* LVM for webserver code, and data. Currently 10GB

Install, and configure *lvm*::

  sudo aptitude install lvm2
  modprobe dm-mod

For future, add *dm-mod* at end of */etc/modules-load.d/modules.conf*

Edit */etc/lvm/lvm.conf*, and change::

  filter = [ "a/.*/" ]

to::

  filter = [ "a|^/dev/nvme[0-9]n1p1$|^/dev/md[0-9]$|", "r/.*/" ]

LVM for code, and data
~~~~~~~~~~~~~~~~~~~~~~

Format the disk, making 1 partition for the entire disk, and set type to 83 (Linux)::

  sudo fdisk /dev/nvme0n1
   n
   p
   1
   defaults for start, end
   p  # Check Linux (83)
   w


As this is the first LVM, no volume groups should be available. So::

  sudo vgscan

should return nothing. Create, and set up the volume groups::

  sudo pvcreate /dev/nvme0n1p1  # 10GB disk was added last
  sudo vgcreate web /dev/nvme0n1p1  # "web" becomes the partition label
  sudo lvcreate -l100%FREE -nDATA web  # "DATA" is the name of the volume
  sudo mkfs -t ext4 /dev/mapper/web-DATA  # Create ext4 filesystem
  sudo mkdir /mnt/data
  sudo mount /dev/mapper/web-DATA /mnt/data

Add the following line to /etc/fstab::

  /dev/mapper/web-DATA /mnt/data ext4 defaults 0 0

Add swap
~~~~~~~~

Add a 2GB swapfile::

  sudo fallocate -l 2G /swapfile
  sudo dd if=/dev/zero of=/swapfile bs=2048 count=1048576
  sudo chmod 600 /swapfile
  sudo mkswap /swapfile
  sudo swapon /swapfile
  sudo swapon --show

Can also check with *top*  that swap is being used. Add entry in */etc/fstab*::

  /swapfile   swap    swap    defaults        0       0

uWSGI setup
-----------

Besides the normal setup with *uwsgi-emperor* we will need to build a uWSGI plugin for Python 3.7 as Ubuntu 18.04 does not come with such a plugin::
  sudo aptitude install python3-distutils uwsgi uwsgi-src uwsgi-dev uuid-dev libcap-dev libpcre3-dev
  cd
  export PYTHON=python3.7
  uwsgi --build-plugin "/usr/src/uwsgi/plugins/python python37"
  sudo mv python37_plugin.so /usr/lib/uwsgi/plugins/
  sudo chmod 644 /usr/lib/uwsgi/plugins/python37_plugin.so

Test that it is working with::
  uwsgi --plugin python37 -s :0
  
which should show the Python version as 3.7. When setting up a uWSGI .ini file one will need to include::
  plugins=python3.7

AuroraDB
--------

mysql-compatible

autoscaling: 1 (2GB) to 1 (2GB)

security-group: hio-mysql-dbserver (specifically for AuroraDB). Only port 3306 open to local IP of webserver.

AuroraDB server details: serverless, pay as you go

Database copy for test.helpinout.org
++++++++++++++++++++++++++++++++++++

* Took snapshot of existing database from AWS RDS console

* Select the snapshot, and from the Actions menuchoose "Restore from snapshot". enter details of the database (we user Serverless), and start the restore: the process takes 5--10 minutes

* After the new  database becomes available, you will probbaly want to set its capacity. Select the dtabase in the listing from the Databases tab, and choose "Set capacity" from the "Actions" menu

Set up website
---------------

Install PHP base packages, and some additional packages at system level::

   # As admin
   sudo aptitude install php-fpm php-mysql php-xml php-mbstring php-gd php-bcmath php-curl php-xml  php-mbstring  php-gd  php-zip  php-bcmath  php-curl composer

   sudo mkdir /mnt/data/programs
   sudo chown -R webuser.webuser /mnt/data/programs
   # Add webuser, and admin to the www-data group
   sudo adduser webuser www-data  # Takes efffect on next login
   sudo adduser admin www-data

::

   # As webuser
   ln -s /mnt/data/programs ~
   git clone https://github.com/HelpinOutMovement/helpinout-backend-php
   cd helpinout-backend-php

Some additional setup work is needed:

* Run *composer* toinstall dependencies::

    composer update --lock

  Make sure to check *composer* output to ensure that there are no errors. Upon successful installation of packages, *composer* shuld create *vendor/autoload.php* which is used by the PHP site.

* Make *runtime*, and *web/assets* writable by *www-data*: these are used by the Yii framework::

    sudo chown -R www-data.www-data {runtime,web/assets}
    sudo chmod -R g+rw {runtime,web/assets}
    sudo chmod g+x {runtime,web/assets}

* In the base directory for the webapp, *~webuser/programs/helpinout-backend*, edit *web/index.php* to add an extra entry for *app.helpinout.org*

* Add a configuration file in *config/prod.php* with database access details

* Set up a cron job for the *admin* user that matches requests, and offers: "crontab -e" to edit the *crontab*, and add the line::

    * * * * * (cd ~webuser/programs/helpinout-backend-php && php ~webuser/programs/helpinout-backend-php/yii sendnotification/index) > /var/log/helpinout-cron.log 2>&1

  This runs every minute, writing output (currently none), and errors to */var/log/helpinout-cron.log*. This file is handled by *logrotate*, and should be created initially::

    sudo touch /var/log/helpinout-cron.log
    sudo chown www=data.www-data /var/log/helpinout-cron.log
    sudo chmod 664 /var/log/helpinout-cron.log

  Check *crontab* setting with::

    crontab -e

Testing website
+++++++++++++++

A test website is set up along the lines of the production site, with the following differences:

* installation in *~webuser/programs/test-helpinout-backend-php*

  * The test site is running the "dev" branch, while the production site runs the "master" branch

* In *web/index.php*:

  * YII_DEBUG is set to "true"

  * YII_ENV is set to dev

* Database configuration uses an independent database configured in *config/hiotest.php*

* The cron job to match requests, and offers runs every 5 minutes, instead of 1 minute in production

Server hardening
~~~~~~~~~~~~~~~~

Firewall
++++++++

Depend on the AWS firewall, configurable through security groups. Could additionally use *ufw* inside the server, but that requires maintaing two firewalls in sync, and does not add much to security.

SSH
+++

Make changes to */etc/ssh/sshd_config*. Exercise care, as it is possible to lock oneself out of the server by a miconfiguration:

* While making changes, always leave a SSH session to the server open inside a terminal multiplexer such as *tmux*.

* First, backup the */etc/sshd_config* file before making changes

* Check changed configuuration with::

    sudo sshd -t

* Only then restart *sshd*::

    sudo service sshd restart

* Check that a new SSH session to the server can be started

::

   # Disconnect sessions that are idle for 10 minutes, after two checks, i.e.,
   # 20min. total
   ClientAliveInterval 600
   ClientAliveCountMax 2

   # Only allow certain users: exclude root
   AllowUsers admin ubuntu webuser

   # Disable X11Forwarding
   X11Forwarding no

   # Change HostKey preferences
   HostKey /etc/ssh/ssh_host_ed25519_key
   HostKey /etc/ssh/ssh_host_rsa_key

   # Algorithms
   KexAlgorithms diffie-hellman-group-exchange-sha256
   # These chane with OpenSSH version, so first get a list with
   #    ssh -Q key | tr '\012' ,
   # and then remove ssh-rsa from the list
   HostKeyAlgorithms ssh-ed25519,ssh-ed25519-cert-v01@openssh.com,sk-ssh-ed25519@openssh.com,sk-ssh-ed25519-cert-v01@openssh.com,ssh-dss,ecdsa-sha2-nistp256,ecdsa-sha2-nistp384,ecdsa-sha2-nistp521,sk-ecdsa-sha2-nistp256@openssh.com,ssh-rsa-cert-v01@openssh.com,ssh-dss-cert-v01@openssh.com,ecdsa-sha2-nistp256-cert-v01@openssh.com,ecdsa-sha2-nistp384-cert-v01@openssh.com,ecdsa-sha2-nistp521-cert-v01@openssh.com,sk-ecdsa-sha2-nistp256-cert-v01@openssh.com

Regenerate a new file for Diffie-Hellman key exchange (this takes about 5 min. on a AWS t3a.medium instance)::

  ssh-keygen -G moduli-2048.candidates -b 2048
  ssh-keygen -T moduli-2048 -f moduli-2048.candidates

# ssh command-line options have changed in Ubuntu 20.04::

  ssh-keygen -M generate -O bits=2048 moduli-2048.candidates
  ssh-keygen -M screen -f moduli-2048.candidates moduli-2048

# Back up existing sile, and copy new one::

  sudo cp /etc/ssh/moduli /etc/ssh/bak.moduli
  sudo mv moduli-2048 /etc/ssh/moduli

Run a SSH audit. Clone *ssh-audit* from Github, and run it::

  git clone https://github.com/jtesta/ssh-audit.git
  cd ssh-audit/
  python ssh-audit.py helpinout.org

We get all green with Ubuntu 18.04, and some orange warnings with Ubuntu 20.04

We get two reds for RSA 2048-bit algorithm, and hashing. As this seems to involve changing system keys, we have not done that.

Fail2Ban
++++++++

Install *fail2ban*::

  sudo aptitude install fail2ban

CHange configuration::

  # Copy main configuraton file to local file, and edit that
  sudo cp  /etc/fail2ban/jail.conf /etc/fail2ban/jail.local

In */etc/fail2ban/jail.local* add::

  [sshd]
  enabled = true
  port = ssh
  logpath = %(sshd_log)s

Restart *fail2ban*::

  sudo service fail2ban restart

Additional server vonfiguration
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

logrotate
+++++++++

The following files are added to */etc/logrotate.d/* and the */etc/logrotate.d/nginx*file is modified to create the *nginx* logs with ownership by *www-data.www-data*, and permission 0640:

* helpinout_app: Yii log files in *runtime/logs/appXXX.log*
* helpinout_cron: production cron
* helpinout_test: Yii log files for test server
* helpinout_test_cron: test cron

logwatch
++++++++

Logging, and monitoring
~~~~~~~~~~~~~~~~~~~~~~~

Logwatch
++++++++

Logrotate
+++++++++

Modified */etc/logrotate.d/{nginx,php7.2-fpm}* to create logs with group *www-data* that are readable by the group so that *webuser* can read them.

Added */etc/logrotate.d/helpinout_app* to rotate logs for the backend PHP application. These are stord under *~webuser/programs/helpinout-backend-php/runtime/logs/*

AWS Cloudwatch
++++++++++++++
