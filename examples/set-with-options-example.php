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

printBanner("*                      Momento Set-With-Options Example Start                     *", $logger);

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

// 1. Set a key with a ttl of 60 seconds (EX option)
$options = ['EX' => 60];
$logger->info("Setting key: $KEY to value: $VALUE with options: " . json_encode($options) . "\n");
try {
    $setResponse = $momentoCacheClient->set($KEY, $VALUE, $options);
    $logger->info("Set response: " . json_encode($setResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error setting key: $KEY to value: $VALUE with options: " . json_encode($options) . "\n");
    exit(1);
}

// 2. Set a key with a ttl of 30000 milliseconds (PX option)
$options = ['PX' => 30000];
$logger->info("Setting key: $KEY to value: $VALUE with options: " . json_encode($options) . "\n");
try {
    $setResponse = $momentoCacheClient->set($KEY, $VALUE, $options);
    $logger->info("Set response: " . json_encode($setResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error setting key: $KEY to value: $VALUE with options: " . json_encode($options) . "\n");
    exit(1);
}

// 3. Set a key to expire at a specific UNIX timestamp (EXAT option)
$timestamp = time() + 3600;  // 1 hour from now
$options = ['exat' => $timestamp];
$logger->info("Setting key: $KEY to value: $VALUE with options: " . json_encode($options) . "\n");
try {
    $setResponse = $momentoCacheClient->set($KEY, $VALUE, $options);
    $logger->info("Set response: " . json_encode($setResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error setting key: $KEY to value: $VALUE with options: " . json_encode($options) . "\n");
    exit(1);
}

// 4. Set a key to expire at a specific UNIX timestamp in milliseconds (PXAT option)
$millisecondsTimestamp = round(microtime(true) * 1000) + 3600000;  // 1 hour from now in milliseconds
$options = ['pxat' => $millisecondsTimestamp];
$logger->info("Setting key: $KEY to value: $VALUE with options: " . json_encode($options) . "\n");
try {
    $setResponse = $momentoCacheClient->set($KEY, $VALUE, $options);
    $logger->info("Set response: " . json_encode($setResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error setting key: $KEY to value: $VALUE with options: " . json_encode($options) . "\n");
    exit(1);
}

// 5. Set a key only if it does not already exist (NX option)
$options = ['nx'];
$logger->info("Setting key: $KEY to value: $VALUE with options: " . json_encode($options) . "\n");
try {
    $setResponse = $momentoCacheClient->set($KEY, $VALUE, $options);
    $logger->info("Set response: " . json_encode($setResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error setting key: $KEY to value: $VALUE with options: " . json_encode($options) . "\n");
    exit(1);
}

// 6. Set a key only if it already exists (XX option)
$options = ['xx'];
$logger->info("Setting key: $KEY to value: $VALUE with options: " . json_encode($options) . "\n");
try {
    $setResponse = $momentoCacheClient->set($KEY, $VALUE, $options);
    $logger->info("Set response: " . json_encode($setResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error setting key: $KEY to value: $VALUE with options: " . json_encode($options) . "\n");
    exit(1);
}

// Note: Exceptions will be thrown for unsupported options like 'get' and 'keepttl', so these are omitted in the examples.

// Cleanup test cache
$response = $client->deleteCache($CACHE_NAME);
if ($response->asSuccess()) {
    $logger->info("Deleted cache " . $CACHE_NAME . "\n");
} elseif ($response->asError()) {
    $logger->info("Error deleting cache: " . $response->asError()->message() . "\n");
    exit(1);
}

printBanner("*                      Momento Set-With-Options Example End                     *", $logger);
