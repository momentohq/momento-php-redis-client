<?php

use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\MomentoRedisClient;
use PHPUnit\Framework\TestCase;

class MomentoRedisClientTest extends TestCase
{
    private static MomentoRedisClient $client;

    /**
     * Setup cache client before each class.
     */
    public static function setUpBeforeClass(): void
    {
        SetupIntegrationTest::setupIntegrationTest();
        self::$client = SetupIntegrationTest::getClient();
    }

    /**
     * Test setting and getting a key-value pair.
     * @throws Exception
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
     * Test getting a non-existent key.
     */
    public function testGetNonExistentKey(): void
    {
        $key = 'non_existent_key';

        $retrievedValue = self::$client->get($key);
        $this->assertFalse($retrievedValue, "Expected null for a non-existent key");
    }

    /**
     * Tear down after all tests. This will clean up Redis or Momento resources.
     * @throws InvalidArgumentError
     */
    public static function tearDownAfterClass(): void
    {
        SetupIntegrationTest::tearDownIntegrationTests();
    }
}
