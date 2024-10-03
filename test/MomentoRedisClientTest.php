<?php

use Momento\Cache\MomentoRedisClient;
use Momento\Cache\Errors\InvalidArgumentError;
use PHPUnit\Framework\TestCase;

class MomentoRedisClientTest extends TestCase
{
    private const CACHE_NAME = 'cache';
    private $client;

    /**
     * @throws InvalidArgumentError|RedisException
     */
    protected function setUp(): void
    {
        $this->client = $this->createCacheClient();
    }

    /**
     * Create a cache client based on the environment variable.
     * @throws InvalidArgumentError|RedisException
     */
    private function createCacheClient()
    {
        $cacheClientType = getenv('CACHE_CLIENT') ?: 'momento';

        if ($cacheClientType === 'redis') {
            return $this->createRedisClient();
        } else {
            return new MomentoRedisClient(self::CACHE_NAME, 60);
        }
    }

    /**
     * Create and return a Redis client.
     * @throws RedisException
     */
    private function createRedisClient(): Redis
    {
        $redisClient = new Redis();
        $redisClient->connect('172.17.0.3', 6379);
        return $redisClient;
    }

    /**
     * @throws Exception
     */
    public function testSetAndGetKeyValue(): void
    {
        $key = 'test_key';
        $value = 'test_value';

        $result = $this->client->set($key, $value);
        $this->assertTrue($result, "Failed to set the key-value pair");

        $retrievedValue = $this->client->get($key);
        $this->assertEquals($value, $retrievedValue, "Failed to retrieve the value for the key");
    }

    /**
     * @throws RedisException
     */
    public function testGetNonExistentKey(): void
    {
        $key = 'non_existent_key';

        $retrievedValue = $this->client->get($key);
        $this->assertFalse($retrievedValue, "Expected false for a non-existent key");
    }

    /**
     * @throws RedisException
     */
    protected function tearDown(): void
    {
        if ($this->client instanceof Redis) {
            $this->client->flushDB();
        }
    }
}
