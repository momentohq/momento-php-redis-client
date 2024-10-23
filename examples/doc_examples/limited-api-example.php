<?php
declare(strict_types=1);


use Momento\Auth\CredentialProvider;
use Momento\Cache\CacheClient;
use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\MomentoCacheClient;
use Momento\Config\Configurations\Laptop;
use Momento\Logging\StderrLoggerFactory;

require "vendor/autoload.php";

// Setup global variables for cache name, TTL, key, and value
$CACHE_NAME = uniqid("php-example-");
$ITEM_DEFAULT_TTL_SECONDS = 60;
$KEY = uniqid("myKey-");
$VALUE = uniqid("myValue-");

// Setup MomentoCacheClient
/**
 * @throws InvalidArgumentError | Exception
 */
function main(): void
{
    // Create a Momento cache client
    $authProvider = CredentialProvider::fromEnvironmentVariable("MOMENTO_API_KEY");
    $configuration = Laptop::latest(new StderrLoggerFactory());
    $client = new CacheClient($configuration, $authProvider, $GLOBALS['ITEM_DEFAULT_TTL_SECONDS']);
    $logger = $configuration->getLoggerFactory()->getLogger("ex:");

    // This interface provides type safety as it only allows the user to interact with the Redis commands that are supported by MomentoCacheClient class
    $momentoCacheClient = new MomentoCacheClient($client, $GLOBALS['CACHE_NAME']);
}
