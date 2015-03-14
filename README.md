# Lost and Found

Web-service for announcements of lost and found things.

> *Currently in development. Things may change or break until a solid release has been announced.*

[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/stfalcon-studio/lost-and-found.svg?style=flat-square)](https://scrutinizer-ci.com/g/stfalcon-studio/lost-and-found/)
[![Build Status](https://img.shields.io/travis/stfalcon-studio/lost-and-found.svg?style=flat-square)](https://travis-ci.org/stfalcon-studio/lost-and-found)
[![Codecov](https://img.shields.io/codecov/c/github/stfalcon-studio/lost-and-found.svg?style=flat-square)](https://codecov.io/github/stfalcon-studio/lost-and-found?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/stfalcon-studio/lost-and-found.svg?style=flat-square)](https://packagist.org/packages/stfalcon-studio/lost-and-found)
[![Latest Stable Version](https://img.shields.io/packagist/v/stfalcon-studio/lost-and-found.svg?style=flat-square)](https://packagist.org/packages/stfalcon-studio/lost-and-found)
[![License](https://img.shields.io/packagist/l/stfalcon-studio/lost-and-found.svg?style=flat-square)](https://packagist.org/packages/stfalcon-studio/lost-and-found)
[![Dependency Status](https://www.versioneye.com/user/projects/5503fd1a4a1064f144000002/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/5503fd1a4a1064f144000002)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/b2b46a6e-33d7-4019-8b3f-6269dc1e395c.svg?style=flat-square)](https://insight.sensiolabs.com/projects/b2b46a6e-33d7-4019-8b3f-6269dc1e395c)
[![HHVM](https://img.shields.io/hhvm/stfalcon-studio/lost-and-found.svg?style=flat-square)](http://hhvm.h4cc.de/package/stfalcon-studio/lost-and-found)
[![Gitter](https://img.shields.io/badge/gitter-join%20chat-brightgreen.svg?style=flat-square)](https://gitter.im/stfalcon-studio/lost-and-found?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## History

This service started as a training project for students from <a href="http://xpk.km.ua">Khmelnytskyi Polytechnic College</a> during their practice
at <a href="http://stfalcon.com">Studio Stfalcon.com</a>.
You can also check a <a href="http://www.slideshare.net/stfalconcom/ss-45226961">presentation</a>
and <a href="https://youtu.be/3EgilE_fpkI">video</a> about that practice.

## Requirements

* PHP 5.4 *and later*
* Symfony 2.6 *and later*
* Doctrine 2.4 *and later*
* Facebook application

## Installation

#### Install Composer

```bash
$ curl -s https://getcomposer.org/installer | php
```

#### Create project via Composer

```bash
$ composer.phar create-project -s dev stfalcon-studio/lost-and-found lost-and-found
```

`-s dev` means non-stable version, until we make first stable release.

#### Check your system configuration

Before you begin, make sure that your local system is properly configured for Symfony2.
To do this, execute the following:

```bash
$ php app/check.php
```

If you got any warnings or recommendations, fix them before moving on.

#### Setting up permissions for directories `app/cache/` and `app/logs`

```bash
$ HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
$ sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
$ sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
````

#### Change DBAL settings, create DB, update it and load fixtures

Change DBAL setting if your need in `app/config/config.yml`, `app/config/config_dev.yml` or
`app/config/config_test.yml`. After that execute the following:

```bash
$ ./console doctrine:database:create
$ ./console doctrine:migrations:migrate
$ ./console doctrine:fixtures:load
```

You can set `test` environment for command if you add `--env=test` to it.

#### Create new application on GitHub
 
* Register as <a href="https://developers.facebook.com">Facebook Developer</a>
* Then open <a href="https://developers.facebook.com/quickstarts/?platform=web">https://developers.facebook.com/quickstarts/?platform=web</a>
* Type the name of your application, e.g. *Lost and Found. Localhost*
* Press "Create New Facebook App ID"
* Choose category "Apps for Pages"
* Press "Create App ID"
* Set your site URL. If it is on localhost, then something like this `http://lost-and-found.localhost/app_dev.php/` and press *Next*
* Use the newly generated `App ID` and `App Secret` parameters for your application, update parameters
`facebook_app_id` and `facebook_app_secret` in *parameters.yml* file

---

That's all. Enjoy "Lost and Found" and send feedback ^_^

![Stfalcon.com Logo](./web/images/stfalcon-logo.png)
