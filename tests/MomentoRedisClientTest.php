<?php

use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\Errors\NotImplementedException;
use Momento\Cache\MomentoCacheClient;
use PHPUnit\Framework\TestCase;

class MomentoRedisClientTest extends TestCase
{
    private static Redis $client;

    /**
     * Setup cache client before each class.
     */
    public static function setUpBeforeClass(): void
    {
        SetupIntegrationTest::setupIntegrationTest();
        self::$client = SetupIntegrationTest::getClient();
    }

    /**
     * @throws RedisException
     */
    public function testSetAndGetKeyValue(): void
    {
        $key = 'test_key';
        $value = 'test_value';

        $result = self::$client->set($key, $value);
        $this->assertTrue($result, "Failed to set the key-value pair");

        $retrievedValue = self::$client->get($key);
        $this->assertEquals($value, $retrievedValue, "Retrieved value does not match the set value");
    }

    /**
     * @throws RedisException
     */
    public function testGetNonExistentKey(): void
    {
        $key = 'non_existent_key';

        $retrievedValue = self::$client->get($key);
        $this->assertFalse($retrievedValue, "Expected null for a non-existent key");
    }

    /**
     * @throws RedisException
     */
    public function testNotImplementedMethodException(): void
    {
        if (!self::$client instanceof MomentoCacheClient) {
            $this->markTestSkipped("This test is only for Momento client");
        }
        $key = 'test_key';
        $value = 'test_value';
        $this->expectException(NotImplementedException::class);
        self::$client->append($key, $value);
    }

    /**
     * Tear down after all tests. This will clean up Redis or Momento resources.
     * @throws InvalidArgumentError | RedisException
     */
    public static function tearDownAfterClass(): void
    {
        SetupIntegrationTest::tearDownIntegrationTests();
    }
}
