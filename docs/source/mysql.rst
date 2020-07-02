.. _chapter:mysql:

Mysql on local server
=====================

In order to economise on costs, we have temporarily switched to running *mysql* on the local server instead of using *AuroraDB*. As the *AuroraDB* version we were using was compatible with *mysql* 5.6, and as it is no longer easily possible to run *mysql* 5.6 on Ubuntu 18.04, we have switched to running it in a *docker* container.

Docker setup
------------

See the writeup on *docker* for detailed Docker installation, and usage instructions. *docker* should have been installed with::

  sudo aptitude install docker.io

The OS package for *docker-compose* on Ubuntu 18.04 is older, and does not recognise some services. Instead, install *docker-compose* from the Github repository::

  # Use the latest version instead of 1.26.1
  sudo curl -L https://github.com/docker/compose/releases/download/1.26.1/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose
  sudo chmod +x /usr/local/bin/docker-compose
  sudo ln -s  /usr/local/bin/docker-compose /usr/bin/

Check that it is running with::

  docker-compose --version


Mysql docker image
------------------

We will use the *docker-compose* file, */opt/mysql5.6/docker-compose.yml* which sets up the *mysql* root user password, and the default *helpinout* user, and password. It also maps *mysql* port 3306 in the container to the same port on the host, and maps the host volume, */mnt/data/docker/mysql* to the *mysql* storage volume in the container, */var/lib/mysql*, allowing persistence of the databases.

Here is */opt/mysql5.6/docker-compose.yml* with passwords obscureed::

  version: '3.1'

  services:

    db:
      image: mysql:5.6
      restart: always
      container_name: mysqsl_db_1
      environment:
         - MYSQL_ROOT_PASSWORD=<root_pass>
	 - MYSQL_USER=<user>
	 - MYSQL_PASS=<pass>
      volumes:
         - /mnt/data/docker/mysql:/var/lib/mysql
      ports:
         - 3306:3306

Start the container with::

  sudo docker-compose up

Connect

Stop it with::

  sudo docker-compose stop

or::

  sudo docker-compose down

Have checked that databases persist through these operations with the required access privileges.

The PHP DSN for the database connections for production, and beta, are in::

  ~webuser/programs/helpinout-backend-php/config/prod.php
  ~webuser/programs/test-helpinout-backend-php/config/hiotest.php

respectively. An important point is that TCP/IP (rather than a UNIX-domain socket) must be used to connect to *mysql* in the container, so one must use a IP address for the host rather than a name like "localhost"::

  <?php

  $custome_array = (array_replace_recursive(
                 require(dirname(__FILE__) . '/config.php'), array(
            'components' => [
                'db' => [
		    'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=helpinout',
                    'username' => '<user>',
                    'password' => '<pass>',
                ],
              ]
           )
        ));

  return $custome_array;
  ?>
