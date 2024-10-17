<?php

use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\Errors\NotImplementedException;
use Momento\Cache\MomentoCacheClient;
use PHPUnit\Framework\TestCase;

class MomentoRedisClientTest extends TestCase
{
    private static Redis $client;
    private static bool $isRedisBackendTest;

    /**
     * Setup cache client before each class.
     * @throws InvalidArgumentError
     */
    public static function setUpBeforeClass(): void
    {
        SetupIntegrationTest::setupIntegrationTest();
        self::$client = SetupIntegrationTest::getClient();
        self::$isRedisBackendTest = SetupIntegrationTest::isRedisBackedTest();
    }

    /**
     * @throws RedisException
     */
    public function testSetAndGetKeyValue(): void
    {
        $key = uniqid();
        $value = uniqid();

        $result = self::$client->set($key, $value);
        $this->assertEquals('OK', $result, "Failed to set the key-value pair");

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
        $this->assertFalse($retrievedValue, "Expected false for a non-existent key");
    }

    /**
     * @throws RedisException
     */
    public function testDeleteKey(): void
    {
        $keys = [];
        $values = [];
        for ($i = 0; $i < 3; $i++) {
            $keys[] = uniqid();
            $values[] = uniqid();
            self::$client->set($keys[$i], $values[$i]);
        }
        $deletedKeys = self::$client->del($keys[0], $keys[1], $keys[2]);
        $this->assertEquals(3, $deletedKeys, "Failed to delete the keys");

        $nonExistentKey = uniqid();
        $deletedKey = self::$client->del($nonExistentKey);

        if (self::$isRedisBackendTest) {
            $this->assertEquals(0, $deletedKey, "Expected 0 for a non-existent key");
        } else {
            $this->assertEquals(1, $deletedKey, "Expected 1 for a non-existent key");
        }

        $retrievedValues = [];
        for ($i = 0; $i < 3; $i++) {
            $retrievedValues[] = self::$client->get($keys[$i]);
            $this->assertFalse($retrievedValues[$i], "Expected false for a deleted key");
        }
    }

    /**
     * @throws RedisException
     */
    public function testIncrementIntegerKey(): void
    {
        $key = uniqid();
        $value = 1;
        $incrAmount = 5;
        self::$client->set($key, $value);

        $incrResult = self::$client->incrBy($key, $incrAmount);
        $this->assertEquals($incrResult, $value + $incrAmount, "Failed to increment the key");
    }

    /**
     * @throws RedisException
     */
    public function testIncrementStringKey(): void
    {
        $key = uniqid();
        $value = uniqid();
        $incrAmount = 5;
        self::$client->set($key, $value);

        $incrResult = self::$client->incrBy($key, $incrAmount);
        $this->assertFalse($incrResult, "Expected false for incrementing a non-integer key");
    }

    /**
     * @throws RedisException
     */
    public function testGetSetWithEx(): void
    {
        $key = uniqid();
        $value = uniqid();
        $setResult = self::$client->set($key, $value, ['ex' => 5]);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair with EX");

        $getResult = self::$client->get($key);
        $this->assertEquals($value, $getResult, "Retrieved value does not match the set value");

        sleep(5);
        $expiredValue = self::$client->get($key);
        $this->assertFalse($expiredValue, "Expected false for an expired key");
    }

    /**
     * @throws RedisException
     */
    public function testGetSetWithPx(): void
    {
        $key = uniqid();
        $value = uniqid();
        $setResult = self::$client->set($key, $value, ['px' => 5000]);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair with EX");

        $getResult = self::$client->get($key);
        $this->assertEquals($value, $getResult, "Retrieved value does not match the set value");

        sleep(5);
        $expiredValue = self::$client->get($key);
        $this->assertFalse($expiredValue, "Expected false for an expired key");
    }

    /**
     * @throws RedisException
     */
    public function testGetSetWithExat(): void
    {
        $key = uniqid();
        $value = uniqid();
        $setResult = self::$client->set($key, $value, ['exat' => time() + 5]);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair with EXAT");

        $getResult = self::$client->get($key);
        $this->assertEquals($value, $getResult, "Retrieved value does not match the set value");

        sleep(5);
        $expiredValue = self::$client->get($key);
        $this->assertFalse($expiredValue, "Expected false for an expired key");
    }

    /**
     * @throws RedisException
     */
    public function testGetSetWithPxat(): void
    {
        $key = uniqid();
        $value = uniqid();
        $setResult = self::$client->set($key, $value, ['pxat' => time() * 1000 + 5000]);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair with PXAT");

        $getResult = self::$client->get($key);
        $this->assertEquals($value, $getResult, "Retrieved value does not match the set value");

        sleep(5);
        $expiredValue = self::$client->get($key);
        $this->assertFalse($expiredValue, "Expected false for an expired key");
    }

    /**
     * @throws RedisException
     */
    public function testSetValueWithNxWhenKeyDoesNotExist(): void
    {
        $key = uniqid();
        $value = uniqid();
        $setResult = self::$client->set($key, $value, ['nx']);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair with NX");

        $retrievedValue = self::$client->get($key);
        $this->assertEquals($value, $retrievedValue, "Retrieved value does not match the set value");
    }

    /**
     * @throws RedisException
     */
    public function testSetValueWithNxWhenKeyExists(): void
    {
        $key = uniqid();
        $value = uniqid();
        $setResult = self::$client->set($key, $value);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair");

        $setResult1 = self::$client->set($key, $value, ['nx']);
        $this->assertFalse($setResult1, "Expected false for an existing key");
    }

    /**
     * @throws RedisException
     */
    public function testSetWithNxAndExpireWhenKeyDoesNotExist(): void
    {
        $key = uniqid();
        $value = uniqid();
        // Set key with NX and EX option (expire in 5 seconds)
        $setResult = self::$client->set($key, $value, ['nx', 'ex' => 5]);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair with NX and EX");

        $getResult = self::$client->get($key);
        $this->assertEquals($value, $getResult, "Retrieved value does not match the set value");

        sleep(5);
        $expiredValue = self::$client->get($key);
        $this->assertFalse($expiredValue, "Expected false for an expired key");
    }

    /**
     * @throws RedisException
     */
    public function testSetWithNxAndPxat()
    {
        $key = uniqid();
        $value = uniqid();
        $timestampInMillis = round(microtime(true) * 1000) + 5000;

        // Set key with NX and PXAT option (expiry at a specific timestamp in milliseconds)
        $setResult = self::$client->set($key, $value, [
            'nx',
            'pxat' => $timestampInMillis
        ]);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair with NX and PXAT");

        $getResult = self::$client->get($key);
        $this->assertEquals($value, $getResult, "Retrieved value does not match the set value");

        $setResult1 = self::$client->set($key, $value, [
            'nx',
            'pxat' => $timestampInMillis
        ]);
        $this->assertFalse($setResult1, "Expected false for an existing key");

        sleep(5);

        $getResult1 = self::$client->get($key);
        $this->assertFalse($getResult1, "Expected false for an expired key");
    }

    /**
     * @throws RedisException
     */
    public function testSetValueWithXxWhenKeyExists(): void
    {
        $key = uniqid();
        $value = uniqid();

        $setResult = self::$client->set($key, $value);
        $this->assertEquals('OK', $setResult, "Failed to set the initial key-value pair");

        $newValue = uniqid();
        $setResult1 = self::$client->set($key, $newValue, ['xx']);
        $this->assertEquals('OK', $setResult1, "Expected 'OK' when key exists for XX");
    }

    /**
     * @throws RedisException
     */
    public function testSetValueWithXxWhenKeyDoesNotExist(): void
    {
        $key = uniqid();
        $value = uniqid();

        $setResult = self::$client->set($key, $value, ['xx']);
        $this->assertFalse($setResult, "Expected false when key does not exist for XX");
    }

    /**
     * @throws RedisException
     */
    public function testSetNxWhenKeyExists(): void
    {
        $key = uniqid();
        $value = uniqid();
        $setResult = self::$client->set($key, $value);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair");

        $setResult1 = self::$client->setnx($key, $value);
        $this->assertFalse($setResult1, "Expected false for an existing key");
    }

    /**
     * @throws RedisException
     */
    public function testSetNxWhenKeyDoesNotExist(): void
    {
        $key = uniqid();
        $value = uniqid();

        $setResult = self::$client->setnx($key, $value);
        $this->assertEquals('OK', $setResult, "Expected OK for non-existing key");
        $getResult = self::$client->get($key);
        $this->assertEquals($value, $getResult, "Retrieved value does not match the set value");
    }

    /**
     * @throws RedisException
     */
    public function testNotImplementedMethodException(): void
    {
        if (!self::$client instanceof MomentoCacheClient) {
            $this->markTestSkipped("This test is only for Momento client");
        }
        $key = uniqid();
        $value = uniqid();
        $this->expectException(NotImplementedException::class);
        $this->expectExceptionMessage("Command not implemented: append");
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
