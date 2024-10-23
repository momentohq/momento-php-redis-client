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

// Perform operations vs Momento as if using a regular Redis client
$setResult = $momentoCacheClient->set($KEY, $VALUE);
$logger->info("Set result: " . $setResult . "\n");

$getResult = $momentoCacheClient->get($KEY);
$logger->info("Get result: " . $getResult . "\n");
