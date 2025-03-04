<?php

use Dotenv\Dotenv;
use Momento\Auth\EnvMomentoTokenProvider;
use Momento\Cache\CacheClient;
use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\MomentoCacheClient;
use Momento\Config\Configurations\Laptop;
use Psr\Log\LoggerInterface;
use Momento\Logging\StderrLoggerFactory;

class SetupIntegrationTest
{
    protected static Redis $client;
    protected static string $cacheName;
    protected static LoggerInterface $logger;
    static string $testBackend;

    /**
     * Set up the client based on the environment. This will run once before all tests.
     * @throws RedisException
     * @throws InvalidArgumentError
     */
    public static function setupIntegrationTest(): void
    {
        self::$cacheName = self::getTestCacheName();
        self::$logger = (new StderrLoggerFactory())->getLogger("integration-test");
        self::$testBackend = getenv('TEST_BACKEND');
        if (self::$testBackend === "redis") {
            self::$logger->info("Running Redis backed tests");
            self::$client = self::setupRedisClient();
        } elseif (self::$testBackend === "momento") {
            self::$logger->info("Running Momento backed tests");
            self::$client = self::setupMomentoClient();
        } else {
            self::$logger->error("Invalid TEST_BACKEND value. Please set TEST_BACKEND to 'redis' or 'momento'.");
            throw new RuntimeException("Invalid TEST_BACKEND value. Please set TEST_BACKEND to 'redis' or 'momento'.");
        }
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
    private static function setupMomentoClient(): Redis
    {
        $ttl = 60;
        $configuration = Laptop::latest(new StderrLoggerFactory());
        $authProvider = new EnvMomentoTokenProvider('MOMENTO_API_KEY');
        $momentoClient = new CacheClient($configuration, $authProvider, $ttl);
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
            self::$logger->info("Cache '$cacheName' created successfully.");
        } elseif ($result->asAlreadyExists()) {
            self::$logger->info("Cache '$cacheName' already exists.");
        } elseif ($result->asError()) {
            self::$logger->error("Error creating cache '$cacheName': " . $result->asError()->message());
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
        if (getenv('TEST_BACKEND') === "redis") {
            self::$client->flushDB();
            self::$client->close();
        } else {
            $configuration = Laptop::latest();
            $authProvider = new EnvMomentoTokenProvider('MOMENTO_API_KEY');
            $momentoClient = new CacheClient($configuration, $authProvider, 60);
            $logger = $configuration->getLoggerFactory()->getLogger("integration-test");
            $result = $momentoClient->deleteCache(self::$cacheName);
            if ($result->asSuccess()) {
                self::$logger->info("Cache '" . self::$cacheName . "' deleted successfully.");
            } elseif ($result->asError()) {
                self::$logger->error("Error deleting cache '" . self::$cacheName . "': " . $result->asError()->message());
            }
        }
    }
}
