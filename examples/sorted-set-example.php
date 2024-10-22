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
$ITEM_DEFAULT_TTL_SECONDS = 120;
$KEY = uniqid("sorted-set-key-");
$VALUE = uniqid("sorted-set-value-");

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

printBanner("*                      Momento PhpRedis Client SortedSet Example Start                     *", $logger);

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


// 1: Adding a single score-member pair (zAdd)
$logger->info("Adding a single score-member pair\n");
$member = "member-1";
$score = 1.0;
try {
    $zAddResponse = $momentoCacheClient->zAdd($KEY, $score, $member);
    $logger->info("zAdd response: " . json_encode($zAddResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error adding score: $score, member: $member\n");
    exit(1);
}

// 2: Adding multiple score-member pairs (zAdd)
$logger->info("Adding multiple score-member pairs\n");
$member1 = "member-1";
$member2 = "member-2";
$member3 = "member-3";
$member4 = "member-4";
$score1 = 1.0;
$score2 = 2.0;
$score3 = 3.0;
$score4 = 4.0;
try {
    $zAddResponse = $momentoCacheClient->zAdd($KEY, $score1, $member1, $score2, $member2, $score3, $member3, $score4, $member4);
    $logger->info("zAdd response: " . json_encode($zAddResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error adding score: $score, member: $member\n");
    exit(1);
}

// Note: Exceptions will be thrown for unsupported options like 'nx', 'xx', 'gt', 'lt', 'ch' and 'incr', so these are omitted in the zAdd examples.

// 3. Incrementing the score of a member
$logger->info("Incrementing the score of a member\n");
$member = "member-1";
$incrementAmount = 5.0;
try {
    $zIncrByResponse = $momentoCacheClient->zIncrBy($KEY, $incrementAmount, $member);
    $logger->info("zIncrBy response: " . json_encode($zIncrByResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error incrementing score: $incrementAmount, member: $member\n");
    exit(1);
}

// 4. Get all elements without score in descending order (zRevRange)
$logger->info("Get elements without score\n");
$rangeStart = 0;
$rangeEnd = -1;
try {
    $zRangeResponse = $momentoCacheClient->zRevRange($KEY, $rangeStart, $rangeEnd);
    $logger->info("zRange response: " . json_encode($zRangeResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error getting elements without score\n");
    exit(1);
}

// 5. Get all elements with score in descending order (zRevRange with scores)
$logger->info("Get elements with score\n");
$rangeStart = 0;
$rangeEnd = -1;
try {
    $zRevRangeWithScoresResponse = $momentoCacheClient->zRevRange($KEY, $rangeStart, $rangeEnd, true);
    $logger->info("zRevRangeWithScores response: " . json_encode($zRevRangeWithScoresResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error getting elements with score\n");
    exit(1);
}

// 6. Get all elements by score in descending order (zRevRangeByScore)
$logger->info("Get elements by score\n");
$max = "3.0";
$min = "1.0";
try {
    $zRevRangeByScoreResponse = $momentoCacheClient->zRevRangeByScore($KEY, $max, $min, false);
    $logger->info("zRevRangeByScore response: " . json_encode($zRevRangeByScoreResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error getting elements by score\n");
    exit(1);
}

// 7. Get all elements by score in descending order with scores (zRevRangeByScore with scores)
$logger->info("Get elements by score with scores\n");
$max = "3.0";
$min = "1.0";
try {
    $zRevRangeByScoreWithScoresResponse = $momentoCacheClient->zRevRangeByScore($KEY, $max, $min, ['withscores' => true]);
    $logger->info("zRevRangeByScoreWithScores response: " . json_encode($zRevRangeByScoreWithScoresResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error getting elements by score with scores\n");
    exit(1);
}

// 8. Get all elements by score in descending order with scores (zRevRangeByScore with limit)
$logger->info("Get elements by score with limit\n");
$max = "3.0";
$min = "1.0";
$limit = [0, 2];
try {
    $zRevRangeByScoreWithLimitResponse = $momentoCacheClient->zRevRangeByScore($KEY, $max, $min, ['limit' => $limit]);
    $logger->info("zRevRangeByScoreWithLimit response: " . json_encode($zRevRangeByScoreWithLimitResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error getting elements by score with limit\n");
    exit(1);
}

// 9. Count the number of members in a sorted set with scores inside a provided range (zCount)
$logger->info("Count the number of members in a sorted set with scores inside a provided range\n");
$start = "1.0";
$end = "3.0";
try {
    $zCountResponse = $momentoCacheClient->zCount($KEY, $start, $end);
    $logger->info("zCount response: " . json_encode($zCountResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error counting members in range: $start, $end\n");
    exit(1);
}

// 10. Get the score of a member of a sorted set (zScore)
$logger->info("Get the score of a member of a sorted set\n");
$member = "member-1";
try {
    $zScoreResponse = $momentoCacheClient->zScore($KEY, $member);
    $logger->info("zScore response: " . json_encode($zScoreResponse) . "\n");
} catch (Exception $e) {
    $logger->info("Error getting score for member: $member\n");
    exit(1);
}

// 11. Remove single element from sorted set (zRem)
$logger->info("Remove single element from sorted set\n");
$member = "member-1";
try {
    $zRemResponse = $momentoCacheClient->zRem($KEY, $member);
    $logger->info("zRem response: " . ($zRemResponse ? 'Success' : 'Failure') . "\n");
} catch (Exception $e) {
    $logger->info("Error removing member: $member\n");
    exit(1);
}

// 12. Remove multiple elements from sorted set (zRem)
$logger->info("Remove multiple elements from sorted set\n");
$member2 = "member-2";
$member3 = "member-3";
try {
    $zRemResponse = $momentoCacheClient->zRem($KEY, $member2, $member3);
    $logger->info("zRem response: " . ($zRemResponse ? 'Success' : 'Failure') . "\n");
} catch (Exception $e) {
    $logger->info("Error removing members: $member2, $member3\n");
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

printBanner("*                      Momento PhpRedis Client SortedSet Example End                     *", $logger);
