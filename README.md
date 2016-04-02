# MonkeyLearn API PHP Client

[![Build Status](http://img.shields.io/travis/artstorm/monkeylearn-api-php/master.svg?style=flat-square)](https://travis-ci.org/artstorm/monkeylearn-api-php)
[![Scrutinizer Code Quality](http://img.shields.io/scrutinizer/g/artstorm/monkeylearn-api-php.svg?style=flat-square)](https://scrutinizer-ci.com/g/artstorm/monkeylearn-api-php/)
[![Scrutinizer Coverage Status](https://img.shields.io/scrutinizer/coverage/g/artstorm/monkeylearn-api-php/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/artstorm/monkeylearn-api-php/code-structure)
[![StyleCI](https://styleci.io/repos/31837635/shield?style=flat-square)](https://styleci.io/repos/31837635)

An easy to use client to consume MonkeyLearn API v2 with PHP.

## Install

Via Composer

``` bash
$ composer require artstorm/monkeylearn-api
```

## Requirements

* PHP >= 5.4.0.
* PHP Curl.


## Basic usage of MonkeyLearn API PHP Client

``` php
$token = 'monkeylearn-api-token';
$client = new Artstorm\MonkeyLearn\Client($token);

$textToClassify = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
$module = 'module_id';
$response = $client->classification->classify($textToClassify, $module);
```


## Debug and Sandbox

MonkeyLearn has a Sandbox mode that can be used for custom modules. There is 
also an option to include debug data in the responses. These options can be 
enabled with the methods `Client::sandbox()` and `Client::debug()`. The methods
are chainable.

``` php
$response = $client->sandbox()->classification->classify($text, $module);
$response = $client->debug()->classification->classify($text, $module);
$response = $client->sandbox()->debug()->classification->classify($text, $module);
```
