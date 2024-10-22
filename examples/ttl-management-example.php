<?php
declare(strict_types=1);

use Momento\Auth\CredentialProvider;
use Momento\Cache\CacheClient;
use Momento\Cache\MomentoCacheClient;
use Momento\Config\Configurations\Laptop;
use Momento\Logging\StderrLoggerFactory;
use Psr\Log\LoggerInterface;

require "vendor/autoload.php";

$CACHE_NAME = uniqid("php-example-");
$ITEM_DEFAULT_TTL_SECONDS = 60;
$KEY = uniqid("myKey-");
$VALUE = uniqid("myValue-");

// Setup MomentoCacheClient
$authProvider = CredentialProvider::fromEnvironmentVariable("MOMENTO_API_KEY");
$configuration = Laptop::latest(new StderrLoggerFactory());
$client = new CacheClient($configuration, $authProvider, $ITEM_DEFAULT_TTL_SECONDS);
$logger = $configuration->getLoggerFactory()->getLogger("ex:");
$momentoCacheClient = new MomentoCacheClient($client, $CACHE_NAME);

function printBanner(string $message, LoggerInterface $logger): void
{
    $line = "******************************************************************";
    $logger->info($line);
    $logger->info($message);
    $logger->info($line);
}

printBanner("*                      Momento TTL-Management Example Start                     *", $logger);

// Ensure test cache exists
$response = $client->createCache($CACHE_NAME);
if ($response->asSuccess()) {
    $logger->info("Created cache " . $CACHE_NAME . "\n");
} elseif ($response->asError()) {
    $logger->info("Error creating cache: " . $response->asError()->message() . "\n");
    exit(1);
} elseif ($response->asAlreadyExists()) {
    $logger->info("Cache " . $CACHE_NAME . " already exists.\n");
}

// Set key using MomentoCacheClient
$logger->info("Setting key: $KEY to value: $VALUE\n");
try {
    $setResponse = $momentoCacheClient->set($KEY, $VALUE);
    $logger->info(("Set response: " . json_encode($setResponse) . "\n"));
} catch (Exception $e) {
    $logger->info("Error setting key: $KEY to value: $VALUE\n");
    exit(1);
}

// Expire key with no mode
$logger->info("Setting key: $KEY to value: $VALUE with default mode " . "\n");
try {
    $expireResponse = $momentoCacheClient->expire($KEY, $ITEM_DEFAULT_TTL_SECONDS);
    $logger->info("Expire key: $KEY with TTL: $ITEM_DEFAULT_TTL_SECONDS seconds using default mode, Result: " . ($expireResponse ? 'Success' : 'Failure'));
} catch (Exception $e) {
    $logger->error("Error setting TTL: " . $e->getMessage());
}

// Expire key with default mode (XX)
$logger->info("Setting key: $KEY to value: $VALUE with mode: ". 'xx' . "\n");
$mode = 'xx';
try {
    $expireResponse = $momentoCacheClient->expire($KEY, $ITEM_DEFAULT_TTL_SECONDS, $mode);
    $logger->info("Expire key: $KEY with TTL: $ITEM_DEFAULT_TTL_SECONDS seconds using 'xx' mode, Result: " . ($expireResponse ? 'Success' : 'Failure'));
} catch (Exception $e) {
    $logger->error("Error setting TTL: " . $e->getMessage());
}

// Expire key with 'lt' mode (decrease TTL)
$logger->info("Setting key: $KEY to value: $VALUE with mode: " . 'lt' . "\n");
$mode = 'lt';
$TTL_LT = 30;
try {
    $expireLtResponse = $momentoCacheClient->expire($KEY, $TTL_LT, $mode);
    $logger->info("Expire key: $KEY with TTL: $TTL_LT seconds using 'lt' mode, Result: " . ($expireLtResponse ? 'Success' : 'Failure'));
} catch (Exception $e) {
    $logger->error("Error setting TTL: " . $e->getMessage());
}

// Expire key with 'gt' mode (increase TTL)
$logger->info("Setting key: $KEY to value: $VALUE with mode: " . 'gt' . "\n");
$mode = 'gt';
$TTL_GT = 90;
try {
    $expireGtResponse = $momentoCacheClient->expire($KEY, $TTL_GT, $mode);
    $logger->info("Expire key: $KEY with TTL: $TTL_GT seconds using 'gt' mode, Result: " . ($expireGtResponse ? 'Success' : 'Failure'));
} catch (Exception $e) {
    $logger->error("Error setting TTL: " . $e->getMessage());
}

// Retrieve TTL for a key
$logger->info("Getting TTL for key: $KEY\n");
try {
    $ttlResponse = $momentoCacheClient->ttl($KEY);
    $logger->info("TTL for key: $KEY is: " . $ttlResponse . "\n");
} catch (Exception $e) {
    $logger->error("Error getting TTL: " . $e->getMessage());
}

// Cleanup test cache
$response = $client->deleteCache($CACHE_NAME);
if ($response->asSuccess()) {
    $logger->info("Deleted cache " . $CACHE_NAME . "\n");
} elseif ($response->asError()) {
    $logger->info("Error deleting cache: " . $response->asError()->message() . "\n");
    exit(1);
}

printBanner("*                      Momento TTL-Management Example End                     *", $logger);

