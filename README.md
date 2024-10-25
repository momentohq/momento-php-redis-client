<img src="https://docs.momentohq.com/img/momento-logo-forest.svg" alt="logo" width="400"/>

[![project status](https://momentohq.github.io/standards-and-practices/badges/project-status-official.svg)](https://github.com/momentohq/standards-and-practices/blob/main/docs/momento-on-github.md)
[![project stability](https://momentohq.github.io/standards-and-practices/badges/project-stability-beta.svg)](https://github.com/momentohq/standards-and-practices/blob/main/docs/momento-on-github.md)


# Momento Drop-in Replacement for PhpRedis

Welcome to the Momento Drop-in Replacement for [PhpRedis](https://github.com/phpredis/phpredis)! This package is a
wrapper around the PhpRedis extension that allows integration with Momento cache. You can use this as a direct
replacement for PhpRedis, while leveraging the benefits of Momento serverless cache.

## Usage

```php
<?php
declare(strict_types=1);

use Momento\Auth\CredentialProvider;
use Momento\Cache\CacheClient;
use Momento\Cache\MomentoCacheClient;
use Momento\Config\Configurations\Laptop;
use Momento\Logging\StderrLoggerFactory;

require "vendor/autoload.php";

$CACHE_NAME = uniqid("php-example-");
$ITEM_DEFAULT_TTL_SECONDS = 60;
$KEY = uniqid("myKey-");
$VALUE = uniqid("myValue-");

// Create a Momento cache client
$authProvider = CredentialProvider::fromEnvironmentVariable("MOMENTO_API_KEY");
$configuration = Laptop::latest(new StderrLoggerFactory());
$client = new CacheClient($configuration, $authProvider, $ITEM_DEFAULT_TTL_SECONDS);
$logger = $configuration->getLoggerFactory()->getLogger("ex:");

// Create a Redis client backed by Momento cache client over the cache
$momentoCacheClient = new MomentoCacheClient($client, $CACHE_NAME);

// IMPORTANT: The example assumes that the cache ($CACHE_NAME) is already created.
// To create a cache, you can use the Momento Console (https://console.gomomento.com/) or SDK methods.
// Refer to the documentation (https://docs.momentohq.com/platform/sdks/php/cache) for details.

// Perform operations vs Momento as if using a regular Redis client
$setResult = $momentoCacheClient->set($KEY, $VALUE);
$logger->info("Set result: " . $setResult . "\n");

$getResult = $momentoCacheClient->get($KEY);
$logger->info("Get result: " . $getResult . "\n");

```

## Getting Started and Documentation

To get started with the drop-in client, you will need a Momento API key. You can get one from the
[Momento Console](https://console.gomomento.com).

## Installation

TODO: fill in section

## Examples

Working example projects, with all required build configuration files, are available
[in the examples directory](./examples/).

## Developing

If you are interested in contributing to the SDK, please see the [CONTRIBUTING](./CONTRIBUTING.md) docs.

## Attributions

This product includes PHP software, freely available from <http://www.php.net/software/>

----------------------------------------------------------------------------------------
For more info, visit our website at [https://gomomento.com](https://gomomento.com)!
