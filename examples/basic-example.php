<?php
declare(strict_types=1);


use Momento\Auth\CredentialProvider;
use Momento\Cache\CacheClient;
use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\MomentoCacheClient;
use Momento\Config\Configurations\Laptop;
use Momento\Logging\StderrLoggerFactory;
use Psr\Log\LoggerInterface;

require "vendor/autoload.php";

// Setup global variables for cache name, TTL, key, and value
$CACHE_NAME = uniqid("php-example-");
$ITEM_DEFAULT_TTL_SECONDS = 60;
$KEY = uniqid("myKey-");
$VALUE = uniqid("myValue-");

// Setup MomentoCacheClient
/**
 * @throws InvalidArgumentError
 */
function createMomentoClient(): array
{
    $authProvider = CredentialProvider::fromEnvironmentVariable("MOMENTO_API_KEY");
    $configuration = Laptop::latest(new StderrLoggerFactory());
    $client = new CacheClient($configuration, $authProvider, $GLOBALS['ITEM_DEFAULT_TTL_SECONDS']);
    $logger = $configuration->getLoggerFactory()->getLogger("ex:");
    return [$client, $logger];
}

function printBanner(string $message, LoggerInterface $logger): void
{
    $line = "******************************************************************";
    $logger->info($line);
    $logger->info($message);
    $logger->info($line);
}

function ensureCacheExists(CacheClient $client, LoggerInterface $logger): bool
{
    $response = $client->createCache($GLOBALS['CACHE_NAME']);
    if ($response->asSuccess()) {
        $logger->info("Created cache " . $GLOBALS['CACHE_NAME'] . "\n");
        return true;
    } elseif ($response->asAlreadyExists()) {
        $logger->info("Cache " . $GLOBALS['CACHE_NAME'] . " already exists.\n");
        return true;
    } elseif ($response->asError()) {
        $logger->info("Error creating cache: " . $response->asError()->message() . "\n");
    }
    return false;
}

function runScalarExamples(MomentoCacheClient $momentoCacheClient, LoggerInterface $logger): bool
{
    $KEY = $GLOBALS['KEY'];
    $VALUE = $GLOBALS['VALUE'];

    // Set key
    $logger->info("Setting key: $KEY to value: $VALUE\n");
    try {
        $setResponse = $momentoCacheClient->set($KEY, $VALUE);
        $logger->info("Set response: " . json_encode($setResponse) . "\n");
    } catch (Exception $e) {
        $logger->info("Error setting key: $KEY to value: $VALUE\n");
        return false;
    }

    // Get key
    $logger->info("Getting key: $KEY\n");
    try {
        $getResponse = $momentoCacheClient->get($KEY);
        $logger->info("Got key: $KEY with value: " . $getResponse . "\n");
    } catch (Exception $e) {
        $logger->info("Error getting key: $KEY\n");
        return false;
    }

    // Delete key
    $logger->info("Deleting key: $KEY\n");
    try {
        $deleteResponse = $momentoCacheClient->del($KEY);
        $logger->info("Deleted key: $KEY\n");
    } catch (Exception $e) {
        $logger->info("Error deleting key: $KEY\n");
        return false;
    }

    return true;
}

/**
 * @throws Exception
 */
function runSortedSetExamples(MomentoCacheClient $momentoCacheClient, LoggerInterface $logger): bool
{
    // Add score-member pairs
    $KEY = uniqid("sorted-set-key-");
    $logger->info("Adding a single score-member pair\n");
    $member1 = uniqid();
    $member2 = uniqid();
    $member3 = uniqid();
    $member4 = uniqid();
    $score1 = 1.0;
    $score2 = 2.0;
    $score3 = 3.0;
    $score4 = 4.0;

    try {
        $zAddResponse = $momentoCacheClient->zAdd($KEY, $score1, $member1, $score2, $member2, $score3, $member3, $score4, $member4);
        $logger->info("zAdd response: " . json_encode($zAddResponse) . "\n");
    } catch (Exception $e) {
        $logger->info("Error adding score: $score1, member: $member1\n");
        return false;
    }

    // Get score-member pairs in descending order
    $logger->info("Getting score-member pairs\n");
    $rangeStart = 0;
    $rangeEnd = -1;
    try {
        $zRangeResponse = $momentoCacheClient->zRevRange($KEY, $rangeStart, $rangeEnd);
        $logger->info("zRange response: " . json_encode($zRangeResponse) . "\n");
    } catch (Exception $e) {
        $logger->info("Error getting score-member pairs\n");
        return false;
    }

    // Get the score of a member
    $logger->info("Getting the score of a member\n");
    try {
        $zScoreResponse = $momentoCacheClient->zScore($KEY, $member1);
        $logger->info("zScore response: " . json_encode($zScoreResponse) . "\n");
    } catch (Exception $e) {
        $logger->info("Error getting the score of member: $member\n");
        return false;
    }

    // Remove a member
    $logger->info("Removing a member\n");
    try {
        $zRemResponse = $momentoCacheClient->zRem($KEY, $member1);
        $logger->info("zRem response: " . json_encode($zRemResponse) . "\n");
    } catch (Exception $e) {
        $logger->info("Error removing member: $member1\n");
        return false;
    }

    return true;

}

function cleanupCache(CacheClient $client, LoggerInterface $logger): void
{
    $response = $client->deleteCache($GLOBALS['CACHE_NAME']);
    if ($response->asSuccess()) {
        $logger->info("Deleted cache " . $GLOBALS['CACHE_NAME'] . "\n");
    } elseif ($response->asError()) {
        $logger->info("Error deleting cache: " . $response->asError()->message() . "\n");
    }
}

/**
 * @throws InvalidArgumentError | Exception
 */
function main(): void
{
    // Create a Momento Client and Logger
    [$cacheClient, $logger] = createMomentoClient();

    // Create a Redis client backed by the Momento cache client over the cache
    $redisClient = new MomentoCacheClient($cacheClient, $GLOBALS['CACHE_NAME']);

    printBanner("*                      Momento PhpRedis Client Example Start                     *", $logger);

    if (!ensureCacheExists($cacheClient, $logger)) {
        return;
    }

    // Perform scalar operations vs Momento as if using a regular Redis client
    if (!runScalarExamples($redisClient, $logger)) {
        cleanupCache($cacheClient, $logger);
        return;
    }

    // Perform sorted set operations vs Momento as if using a regular Redis client
    if (!runSortedSetExamples($redisClient, $logger)) {
        cleanupCache($cacheClient, $logger);
        return;
    }

    cleanupCache($cacheClient, $logger);
    printBanner("*                      Momento PhpRedis Client Example End                     *", $logger);
}

try {
    main();
} catch (InvalidArgumentError|Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
