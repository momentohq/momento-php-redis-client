<?php

use Dotenv\Dotenv;
use Momento\Auth\EnvMomentoTokenProvider;
use Momento\Cache\CacheClient;
use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\MomentoCacheClient;
use Momento\Config\Configurations\Laptop;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class SetupIntegrationTest
{
    protected static Redis $client;
    protected static string $cacheName;

    /**
     * Set up the client based on the environment. This will run once before all tests.
     * @throws RedisException
     * @throws InvalidArgumentError
     */
    public static function setupIntegrationTest(): void
    {

        self::$cacheName = self::getTestCacheName();
        if (self::isRedisBackedTest()) {
            var_dump("Setting up redis client");
            self::$client = self::setupRedisClient();
        } else {
            var_dump("Setting up momento client");
            self::$client = self::setupMomentoClient();
        }
    }

    private static function isRedisBackedTest(): bool
    {
        return $_ENV['TEST_REDIS'] === 'true';
    }

    /**
     * Setup Redis client
     * @throws RedisException
     */
    private static function setupRedisClient(): Redis
    {
        $redis = new Redis();
        $redisHost = $_ENV['REDIS_HOST'] ?: 'localhost';
        $redisPort = $_ENV['REDIS_PORT'] ?: 6379;
        $redis->connect($redisHost, $redisPort);
        return $redis;
    }

    /**
     * Setup Momento client
     * @throws InvalidArgumentError
     */
    private static function setupMomentoClient(): Redis
    {
        $ttl = 60;
        $configurations = Laptop::latest();
        $authProvider = new EnvMomentoTokenProvider('MOMENTO_API_KEY');
        $momentoClient = new CacheClient($configurations, $authProvider, $ttl);
        self::createCacheIfNotExists($momentoClient);
        return new MomentoCacheClient($momentoClient, self::$cacheName);
    }

    /**
     */
    private static function createCacheIfNotExists(CacheClient $client): void
    {
        $cacheName = self::$cacheName;
        $result = $client->createCache($cacheName);

        if ($result->asSuccess()) {
            error_log("Cache '$cacheName' created successfully.");
        } elseif ($result->asAlreadyExists()) {
            error_log("Cache '$cacheName' already exists.");
        } elseif ($result->asError()) {
            error_log("Error creating cache '$cacheName': " . $result->asError()->message());
            throw new RuntimeException("Error creating cache '$cacheName': " . $result->asError()->message());
        }
    }

    private static function getTestCacheName(): string
    {
        $cacheName = $_ENV['TEST_CACHE_NAME'] ?: 'php-integration-test-default';
        return $cacheName . uniqid();
    }

    /**
     * Get the initialized cache client
     */
    public static function getClient(): Redis
    {
        return self::$client;
    }

    /**
     * Tear down after all tests to clear resources (Redis or Momento).
     * @throws InvalidArgumentError|RedisException
     */
    public static function tearDownIntegrationTests(): void
    {
        if (self::isRedisBackedTest()) {
            self::$client->flushDB();
            self::$client->close();
        } else {
            $configurations = Laptop::latest();
            $authProvider = new EnvMomentoTokenProvider('MOMENTO_API_KEY');
            $momentoClient = new CacheClient($configurations, $authProvider, 60);
            $result = $momentoClient->deleteCache(self::$cacheName);
            if ($result->asSuccess()) {
                error_log("Cache '" . self::$cacheName . "' deleted successfully.");
            } elseif ($result->asError()) {
                error_log("Error deleting cache '" . self::$cacheName . "': " . $result->asError()->message());
            }
        }
    }
}
