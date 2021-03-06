# MonkeyLearn API PHP Client

[![Build Status](http://img.shields.io/travis/artstorm/monkeylearn-api-php/master.svg?style=flat-square)](https://travis-ci.org/artstorm/monkeylearn-api-php)
[![Scrutinizer Code Quality](http://img.shields.io/scrutinizer/g/artstorm/monkeylearn-api-php.svg?style=flat-square)](https://scrutinizer-ci.com/g/artstorm/monkeylearn-api-php/)
[![Scrutinizer Coverage Status](https://img.shields.io/scrutinizer/coverage/g/artstorm/monkeylearn-api-php/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/artstorm/monkeylearn-api-php/code-structure)
[![StyleCI](https://styleci.io/repos/31837635/shield?style=flat-square)](https://styleci.io/repos/31837635)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://raw.githubusercontent.com/artstorm/monkeylearn-api-php/master/LICENSE.md)

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

print_r($response->result());
```


### Debug and Sandbox

MonkeyLearn has a Sandbox mode that can be used for custom modules. There is 
also an option to include debug data in the responses. These options can be 
enabled with the methods `Client::sandbox()` and `Client::debug()`. The methods
are chainable.

``` php
$response = $client->sandbox()->classification->classify($text, $module);
$response = $client->debug()->classification->classify($text, $module);
$response = $client->sandbox()->debug()->classification->classify($text, $module);
```


### Query Limits

To find out current query limits with MonkeyLearn API, that information is 
available in the response object.

``` php
$response = $client->classification->classify($text, $module);

$limits = $response->limits();
```


## License

The library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

