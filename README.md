# Overview
This is an example LAMP (Linux Apache MySQL phpMyAdmin) stack based on the excellent starting point from [https://github.com/theknightlybuilders/docker-compose-lamp](https://github.com/theknightlybuilders/docker-compose-lamp)

Instead of reinventing the wheel, I wanted to use this excellent reference as a starting point and tweak as desired. The documentation out of the gate was incredible and is mostly untouched aside from a troubleshooting section I've added below.

## LAMP stack built with Docker Compose

This is a basic LAMP stack environment buit using Docker Compose. It consists following:

* PHP 7.1
* Apache 2.4
* MySQL 5.7
* phpMyAdmin
* Redis 

### Installation

Clone this repository on your local computer. Run the `docker-compose up -d`.

```shell
git clone git@github.com:TheRobBrennan/docker-compose-lamp.git
cd docker-compose-lamp/
docker-compose up -d
```

Your LAMP stack is now ready!! You can access it via `http://localhost`.

#### Troubleshooting
##### Web server already running
One issue I ran into on my MacBook Pro was that the default web server was already running on port 80:
```
Starting rb-webserver ... 
Starting rb-webserver ... error

ERROR: for rb-webserver  Cannot start service webserver: driver failed programming external connectivity on endpoint rb-webserver (f2b516fded41c0938b93f20f01167339e1940e78879be2f5079c1ad9c9fe4f06): Error starting userland proxy: Bind for 0.0.0.0:80: unexpected error (Failure EADDRINUSE)

ERROR: for webserver  Cannot start service webserver: driver failed programming external connectivity on endpoint rb-webserver (f2b516fded41c0938b93f20f01167339e1940e78879be2f5079c1ad9c9fe4f06): Error starting userland proxy: Bind for 0.0.0.0:80: unexpected error (Failure EADDRINUSE)
ERROR: Encountered errors while bringing up the project.
```

To see what process is using the port, you can run:

    $ ps -ef | grep httpd

You will see output similar to:
```
    0   102     1   0 20Nov17 ??         0:18.96 /usr/sbin/httpd -D FOREGROUND
   70   663   102   0 20Nov17 ??         0:00.03 /usr/sbin/httpd -D FOREGROUND
   70 95672   102   0 Sun09PM ??         0:00.00 /usr/sbin/httpd -D FOREGROUND
  501 35845 34955   0 10:52AM ttys010    0:00.00 grep httpd

```

On the MacBook Pro, this was resolved by simply stopping the default apache server in OS X:

    $ sudo apachectl stop

##### Configuring your environment for remote debugging
If you run into issues where XDebug and Docker for Mac are not playing together nicely in your environment, see [https://www.ashsmith.io/docker/get-xdebug-working-with-docker-for-mac/](https://www.ashsmith.io/docker/get-xdebug-working-with-docker-for-mac/) or just create an alias to match the `xdebug.remote_host=10.254.254.254` setting in `php.ini`:

    $ sudo ifconfig lo0 alias 10.254.254.254

If you are using Visual Studio Code (strongly recommended), be sure that you have downloaded and installed the [PHP Debug](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug) extension.

### Configuration

This package comes with default configuration options. You can modify them by creating `.env` file in your root directory.

To make it easy, just copy the content from `sample.env` file and update the environment variable values as per your need.

#### Configuration Variables

There are following configuration variables available and you can customize them by overwritting in your own `.env` file.

_**DOCUMENT_ROOT**_

It is a document root for Apache server. The default value for this is `./www`. All your sites will go here and will be synced automatically.

_**MYSQL_DATA_DIR**_

This is MySQL data directory. The default value for this is `./data/mysql`. All your MySQL data files will be stored here.

_**VHOSTS_DIR**_

This is for virtual hosts. The default value for this is `./config/vhosts`. You can place your virtual hosts conf files here.

_**APACHE_LOG_DIR**_

This will be used to store Apache logs. The default value for this is `./logs/apache2`.

_**MYSQL_LOG_DIR**_

This will be used to store Apache logs. The default value for this is `./logs/mysql`.

## Web Server

Apache is configured to run on port 80. So, you can access it via `http://localhost`.

#### Apache Modules

By default following modules are enabled.

* rewrite

> If you want to enable more modules, just update `./bin/webserver/Dockerfile`. You can also generate a PR and we will merge if seems good for general purpose.
> You have to rebuild the docker image by running `docker-compose build` and restart the docker containers.

## PHP

The installed version of PHP is 7.1.

#### Extensions

By default following extensions are installed.

* mysqli
* mbstring
* zip
* intl
* mcrypt
* curl
* json
* iconv
* xml
* xmlrpc
* gd

> If you want to install more extension, just update `./bin/webserver/Dockerfile`. You can also generate a PR and we will merge if seems good for general purpose.
> You have to rebuild the docker image by running `docker-compose build` and restart the docker containers.

### phpMyAdmin

phpMyAdmin is configured to run on port 8080. Use following default credentials.

http://localhost:8080/  
username: root  
password: tiger
