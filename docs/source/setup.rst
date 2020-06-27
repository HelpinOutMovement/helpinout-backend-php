.. _chapter:setup:

AWS setup
=========

Details of the hardware infrastructure, and software components, are covered in this section.

Infrastructure
--------------

Deployment is solely in the AWS ap-south-1a )Mumbai) region. Use the latest Ubuntu 18.04 AMI from Canonical under "Community AMIs": ubuntu/images/hvm-ssd/ubuntu-bionic-18.04-amd64-server-20200112 - ami-0620d12a9cf777c87

Server size
~~~~~~~~~~~

Single t3a.medium (2 vCPU, 4GB RAM) instance for the webserver, with 10GB on the root partition, and 25 GB for */data*. Both disks are general-purpose SSDs, without IOPS specially configured, and a t3a.medium instance is automatically EBS-optimised. The root partition is set to be deleted on termination while the data partition is not. The CPU is set to burst, i.e., it can use more computing power if the koad gets high, though at an additional cost for times of increased usage. The instance is protected against accidental termination, which means that this must be explictly disabled from the AWS console before it can be terminated: however, it can be stopped when not in use, in which case it incurs no cost.

The instance has an elastic IP of 13.232.159.12, which is not allowed to be reassociated, and is tagged as:

* type: *production*

* category: *master*. There will be a single instance of this category running the software load balancer, *haproxy*. as well as functioning as an application server.

For autoscaling, application server instances will be added, using secueity groups. These are identical to the master server, except that they have a smaller, 5 GB, data disk, and are not running *haproxy*. Cyrrently, there are no running application servers.

Autoscaling
+++++++++++

Manual

Autoscaling groups, and launch templates

Database
~~~~~~~~

Own server vs. RDS vs. AuroraDB
+++++++++++++++++++++++++++++++

Load balancer
-------------

Hardware load balancer vs. haproxy

Reliability
Performance
Autoscaling
Cost

Mailer
~~~~~~

postfix through SES

Webserver
---------

Operating system
~~~~~~~~~~~~~~~~

Hardening
+++++++++

Database
~~~~~~~~

PHP
~~~

Hardening
+++++++++

nginx
~~~~~

Firewall
~~~~~~~~

AWS frewall rules are handled through security groups. Currently, there is one such group, *hio-webserver* with the following inbound ports open to all IP addresses::

  * SSHL 22

  * HTTP: 80

  * HTTPS: 443

There are currently no outbound rules.


Monitoring, and logging
-----------------------

Logwatch
--------

Database
--------

Webserver
---------

Cloudwatch
----------

Alerts
++++++
