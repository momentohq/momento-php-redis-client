<?php

use Dotenv\Dotenv;
use Momento\Auth\EnvMomentoTokenProvider;
use Momento\Cache\CacheClient;
use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\MomentoCacheClient;
use Momento\Cache\MomentoRedisClient;
use Momento\Cache\RedisClient;
use Momento\Config\Configurations\Laptop;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class SetupIntegrationTest
{
    protected static MomentoRedisClient|null $redisClient;
    protected static MomentoRedisClient|null $momentoClient;
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
            var_dump('redis');
            self::$redisClient = self::setupRedisClient();
        } else {
            self::$momentoClient = self::setupMomentoClient();
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
    private static function setupRedisClient(): MomentoRedisClient
    {
        $redis = new Redis();
        $redisHost = $_ENV['REDIS_HOST'] ?: 'localhost';
        $redisPort = $_ENV['REDIS_PORT'] ?: 6379;
        $redis->connect($redisHost, $redisPort);
        return new MomentoRedisClient(new RedisClient($redis));
    }

    /**
     * Setup Momento client
     * @throws InvalidArgumentError
     */
    private static function setupMomentoClient(): MomentoRedisClient
    {
        $ttl = 60;
        $configurations = Laptop::latest();
        $authProvider = new EnvMomentoTokenProvider('MOMENTO_API_KEY');
        $momentoClient = new CacheClient($configurations, $authProvider, $ttl);
        self::createCacheIfNotExists($momentoClient);
        return new MomentoRedisClient(new MomentoCacheClient($momentoClient, self::$cacheName));
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
    public static function getClient(): MomentoRedisClient
    {
        return self::isRedisBackedTest() ? self::$redisClient : self::$momentoClient;
    }

    /**
     * Tear down after all tests to clear resources (Redis or Momento).
     * @throws InvalidArgumentError
     */
    public static function tearDownIntegrationTests(): void
    {
        if (self::isRedisBackedTest()) {
            self::$redisClient->flushDB();
            self::$redisClient = null;
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
            self::$momentoClient = null;
        }
    }
}
