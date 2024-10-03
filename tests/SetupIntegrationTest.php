<?php

use Momento\Auth\EnvMomentoTokenProvider;
use Momento\Cache\CacheClient;
use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\MomentoRedisClient;
use Momento\Config\Configurations\Laptop;

class SetupIntegrationTest
{
    protected static Redis|MomentoRedisClient|null $client;
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
            self::$client = self::setupRedisClient();
        } else {
            self::$client = self::setupMomentoClient();
        }
    }

    private static function isRedisBackedTest(): bool
    {
        return getenv('CACHE_CLIENT') === 'redis';
    }

    /**
     * Setup Redis client
     * @throws RedisException
     */
    private static function setupRedisClient(): Redis
    {
        $redis = new Redis();
        $redisHost = getenv('REDIS_HOST') ?: 'localhost';
        $redisPort = getenv('REDIS_PORT') ?: 6379;
        $redis->connect($redisHost, $redisPort);
        return $redis;
    }

    /**
     * Setup Momento client
     * @throws InvalidArgumentError
     */
    private static function setupMomentoClient(): MomentoRedisClient
    {
        $ttl = 60;
        self::createCacheIfNotExists();
        return new MomentoRedisClient(self::$cacheName, $ttl);
    }

    /**
     * @throws InvalidArgumentError
     */
    private static function createCacheIfNotExists(): void
    {
        $cacheName = self::$cacheName;
        $configurations = Laptop::latest();
        $authProvider = new EnvMomentoTokenProvider('MOMENTO_API_KEY');
        $momentoClient = new CacheClient($configurations, $authProvider, 60);
        $result = $momentoClient->createCache($cacheName);

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
        $cacheName = getenv('TEST_CACHE_NAME') ?: 'php-integration-test-default';
        return $cacheName . uniqid();
    }

    /**
     * Get the initialized cache client
     */
    public static function getClient(): MomentoRedisClient|Redis
    {
        return self::$client;
    }

    /**
     * Tear down after all tests to clear resources (Redis or Momento).
     * @throws InvalidArgumentError
     * @throws RedisException
     */
    public static function tearDownIntegrationTests(): void
    {
        if (self::$client instanceof Redis) {
            self::$client->flushDB();
            self::$client->close();
        }

        if (self::$client instanceof MomentoRedisClient) {
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

        self::$client = null;
    }
}
