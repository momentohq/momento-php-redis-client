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
$VALUE = 2;

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

printBanner("*                      Momento Increment Example Start                     *", $logger);

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

// Increment key using MomentoCacheClient
$logger->info("Incrementing key: $KEY\n");
$incrementAmount = 1;
try {
    $incrementResponse = $momentoCacheClient->incrBy($KEY, $incrementAmount);
    $logger->info("Incremented key: $KEY by $incrementAmount. New value: " . $incrementResponse . "\n");
} catch (Exception $e) {
    $logger->info("Error incrementing key: $KEY\n");
    exit(1);
}

// Cleanup test cache
$response = $client->deleteCache($CACHE_NAME);
if ($response->asSuccess()) {
    $logger->info("Deleted cache " . $CACHE_NAME . "\n");
} elseif ($response->asError()) {
    $logger->info("Error deleting cache: " . $response->asError()->message() . "\n");
    exit(1);
}

printBanner("*                      Momento Increment Example End                     *", $logger);
