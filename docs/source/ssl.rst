.. _chapter:ssl:

SS: certificates
================

We are using SSLcertificates from two sources:

* Purchsed PositiveSSL certificates from NameCheap

* A free widcardcertificate from https://letsencrypt.org

NameCheap PositiveSSL certificates
----------------------------------

Two were purchases for a year, andcover the public-facing sites:

* First one covers htts://helpinout.org, and https://www.helpinout.org

* Second one is for https://app.helpinout.org

Let'sEncrypt certificates
-------------------------

See https://letsencrypt.org/getting-started/ for instructions. Install the *Certbot* application following instructions in the "Wildcard" tab at https://certbot.eff.org/lets-encrypt/ubuntubionic-nginx :

* Install *Certbot*: assuming a wildcard certificate using *nginx*::

      sudo aptitude install certbot python3-certbot-nginx

* Follow instructions for AWS Route 53: https://certbot-dns-route53.readthedocs.io/en/stable/

  * Install certbot plugin for Route 53::

      sudo aptitude install python3-certbot-dns-route53

  * Create a custom IAM policy, *hio-certbot-route53*, with the required permissions. Change "arn:aws:route53:::hostedzone/Z0233100205J5FW3167J8" to the correctARN for the hosted zone::

      {
       "Version": "2012-10-17",
       "Id": "certbot-dns-route53 sample policy",
       "Statement": [
            {
	      "Effect": "Allow",
	      "Action": [
              "route53:ListHostedZones",
              "route53:GetChange"
	    ],
	      "Resource": [
	           "*"
	      ]
	    },
	    {
	      "Effect" : "Allow",
	      "Action" : [
                   "route53:ChangeResourceRecordSets"
	      ],
	      "Resource" : [
                   "arn:aws:route53:::hostedzone/Z0233100205J5FW3167J8"
	      ]
            }
       ]
      }

  * Create a IAM group, *hio-certbot*, using the above policy

  * Create a IAM user, *hio-certbot*, belonging to the *hio-certbot* group. This user will only have programmatic access: make sure to save the credentials forthe AWS CLI setup below.

  * Install AWS CLI for *admin*, and set it up to use the credentials of the above user: //docs.aws.amazon.com/cli/latest/userguide/cli-chap-welcome.html ::

      sudo aptitude install python-pip
      pip install awscli --upgrade --user

    Check for proper installation with::

      aws --version

    If the *aws* command is not found, it might be necessary to add it to your path. Execute the following command::

      export PATH="$PATH:~/.local/bin"

    Add the following to *~/.bash_profile* for future sessions::

      # if running bash
      if [ -n "$BASH_VERSION" ]; then
          # include .bashrc if it exists
	  if [ -f "$HOME/.bashrc" ]; then
              . "$HOME/.bashrc"
	  fi
      fi

      # set PATH so it includes user's private bin if it exists
      if [ -d "$HOME/bin" ] ; then
          PATH="$HOME/bin:$PATH"
      fi

      # set PATH so it includes user's private bin if it exists
      if [ -d "$HOME/.local/bin" ] ; then
          PATH="$HOME/.local/bin:$PATH"
      fi

  * Configuration adds sensitive information (AWS account credentials) to *~/.aws/credentials* so make sure that this is not a shared account accessed by many perople. Configure with::

      aws configure

    Enter data as required, using the credentials for the *hio-certbot* user, and *ap-south-1* (Mumbai for the default region.

  * As somecommands below need to be run as root, copy the *.aws* directory to root' home::

         sudo cp ~admin/.aws /root

  * Use *Certbot* to get a certificate: we do not installit automatically::

      sudo certbot certonly --dns-route53 -d '*.helpinout.org'

    The output tells tou where the certificate chain, and private key have been installed. They are, respectively::

      /etc/letsencrypt/live/helpinout.org/fullchain.pem
      /etc/letsencrypt/live/helpinout.org/privkey.pem

  * These are then entered as usual into a *nginx* configuration file for *nginx*
