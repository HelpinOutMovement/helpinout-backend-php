.. _chapter:intro:

Introduction
============

While security through obscurity is not a goal, and sensitice details are not included here, there is no need to make infrastructure details public. *Please treat this document as confidential within the Helpinout organisation*.

The HelpinOut infrastructure is set up in the AWS Mumbai region. Salient points of the setup are:

* We deploy on burstable (CPU performance is allowed to scale up with load) t3a.medium instances, which are currently on-demand, and not reserved.

  * An autoscaling group, using an Amazon machine image (AMI), and a launch template is set up, but there are no scheduled actions at the moment, i.e., it has no effect but quickly allows turning on autoscaling. Better autoscaling, with policies that depend on server load, and the use of spot instances will be enabled later.

  * Currently, the API server, and the web front-end runs on a single t3a.medium instance.

* The operating system is an AMI based on the latest Ubuntu 18.04 AMI released by Canonical on AWS: AMI ID XXX. A customised AMI has been made after all installation, and configuration was completed. The following components are used:

  * Software load balancer: *haproxy*.

  * Database: AWS' *auroradb*.

  * PHP 7.x with php-fpm

  * *nginx* as a reverse proxy server. Caching is used in *nginx*.

  * Small volumes of system mail is sent through *postfix* using AWS SES.

  * Monitoring is done through *logwatch* and AWS *Cloudwatch*.
