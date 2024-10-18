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
     * @throws InvalidArgumentError|RedisException
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

        sleep(6);
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

        sleep(6);
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

        sleep(6);
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

        sleep(6);
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

        sleep(6);
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

        sleep(6);

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
    public function testItemGetTtl(): void
    {
        $key = uniqid();
        $value = uniqid();
        $ttlSeconds = 10;
        $setResult = self::$client->set($key, $value, ['ex' => $ttlSeconds]);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair");

        $remainingTtlMillis = self::$client->ttl($key);
        $this->assertGreaterThan(0, $remainingTtlMillis, "Expected TTL to be greater than 0");
        $this->assertLessThanOrEqual($ttlSeconds * 1000, $remainingTtlMillis, "Expected TTL to be less than or equal to the set TTL");
    }

    /**
     * @throws RedisException
     */
    public function testItemGetTtlForNonExistentKey(): void
    {
        $key = uniqid();
        $ttlMillis = self::$client->ttl($key);
        $this->assertEquals(-2, $ttlMillis, "Expected -2 for a non-existent key");
    }

    /**
     * @throws RedisException
     */
    public function testExpireWhenKeyDoesNotExist()
    {
        $key = uniqid();
        $value = uniqid();
        self::$client->set($key, $value, ['ex' => 5]);

        sleep(6);

        $updateTtlSeconds = 10;
        $expireResult = self::$client->expire($key, $updateTtlSeconds);
        $this->assertFalse($expireResult, "Expected false for a non-existing key");
    }

    /**
     * @throws RedisException
     */
    public function testExpireWithNullMode()
    {
        $key = uniqid();
        $value = uniqid();
        $setResult = self::$client->set($key, $value, ['ex' => 30]);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair");

        $updateTtlSeconds = 60;
        $expireResult = self::$client->expire($key, $updateTtlSeconds);
        $this->assertTrue($expireResult, "Expected true for an existing key");

        $remainingTtlMillis = self::$client->ttl($key);
        $this->assertGreaterThan(0, $remainingTtlMillis, "Expected TTL to be greater than 0");
        $this->assertLessThanOrEqual($updateTtlSeconds * 1000, $remainingTtlMillis, "Expected TTL to be less than or equal to the set TTL");
    }

    /**
     * @throws RedisException
     */
    public function testExpireWithXx()
    {
        $key = uniqid();
        $value = uniqid();
        $setResult = self::$client->set($key, $value, ['ex' => 30]);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair");

        $updateTtlSeconds = 60;
        $expireResult = self::$client->expire($key, $updateTtlSeconds, 'xx');
        $this->assertTrue($expireResult, "Expected true for an existing key");

        $remainingTtlMillis = self::$client->ttl($key);
        $this->assertGreaterThan(0, $remainingTtlMillis, "Expected TTL to be greater than 0");
        $this->assertLessThanOrEqual($updateTtlSeconds * 1000, $remainingTtlMillis, "Expected TTL to be less than or equal to the set TTL");
    }

    /**
     * @throws RedisException
     */
    public function testExpireWithLt()
    {
        $key = uniqid();
        $value = uniqid();
        $setResult = self::$client->set($key, $value, ['ex' => 60]);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair");

        $updateTtlSeconds = 90;
        $expireResult = self::$client->expire($key, $updateTtlSeconds, 'lt');
        $this->assertFalse($expireResult, "Expected false for a existing key with current TTL less than the update TTL");

        $updateTtlSeconds = 30;
        $expireResult = self::$client->expire($key, $updateTtlSeconds, 'lt');
        $this->assertTrue($expireResult, "Expected true for an existing key with current TTL less than the update TTL");

        $remainingTtlMillis = self::$client->ttl($key);
        $this->assertGreaterThan(0, $remainingTtlMillis, "Expected TTL to be greater than 0");
        $this->assertLessThanOrEqual($updateTtlSeconds * 1000, $remainingTtlMillis, "Expected TTL to be less than or equal to the set TTL");
    }

    /**
     * @throws RedisException
     */
    public function testExpireWithGt()
    {
        $key = uniqid();
        $value = uniqid();
        $setResult = self::$client->set($key, $value, ['ex' => 30]);
        $this->assertEquals('OK', $setResult, "Failed to set the key-value pair");

        $updateTtlSeconds = 10;
        $expireResult = self::$client->expire($key, $updateTtlSeconds, 'gt');
        $this->assertFalse($expireResult, "Expected false for a existing key with current TTL greater than the update TTL");

        $updateTtlSeconds = 60;
        $expireResult = self::$client->expire($key, $updateTtlSeconds, 'gt');
        $this->assertTrue($expireResult, "Expected true for an existing key with current TTL greater than the update TTL");

        $remainingTtlMillis = self::$client->ttl($key);
        $this->assertGreaterThan(0, $remainingTtlMillis, "Expected TTL to be greater than 0");
        $this->assertLessThanOrEqual($updateTtlSeconds * 1000, $remainingTtlMillis, "Expected TTL to be less than or equal to the set TTL");
    }

    /**
     * @throws RedisException
     */
    public function testExpireWithNxException()
    {
        if (!self::$client instanceof MomentoCacheClient) {
            $this->markTestSkipped("This test is only for Momento client");
        }

        $key = uniqid();
        $updateTtlMilliSeconds = 60 * 1000;

        $this->expectException(InvalidArgumentError::class);
        self::$client->expire($key, $updateTtlMilliSeconds, 'nx');
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
     * @throws RedisException
     */
    public function testZAddWithScoreAndMember(): void
    {
        $key = uniqid();
        $member = uniqid();
        $score = 1.0;

        $result = self::$client->zAdd($key, $score, $member);
        $this->assertEquals(1, $result, "Failed to add member with score");

        $elements = self::$client->zRevRange($key, 0, 1, true);
        $this->assertEquals([$member => $score], $elements, "Retrieved elements do not match the added elements");
    }

    /**
     * @throws RedisException
     */
    public function testZAddMultipleElements(): void
    {
        $key = uniqid();
        $member1 = uniqid();
        $member2 = uniqid();
        $score1 = 1.0;
        $score2 = 2.0;

        $result = self::$client->zAdd($key, $score1, $member1, $score2, $member2);
        $this->assertEquals(2, $result, "Failed to add multiple members with scores");

        $elements = self::$client->zRevRange($key, 0, 2, true);
        $this->assertEquals([$member2 => $score2, $member1 => $score1], $elements, "Retrieved elements do not match the added elements");
    }

    /**
     * @throws RedisException
     */
    public function testZAddWithUnsupportedOption(): void
    {
        if (!self::$client instanceof MomentoCacheClient) {
            $this->markTestSkipped("This test is only for Momento client");
        }
        $key = uniqid();
        $member = uniqid();
        $score = 1.0;

        $this->expectException(InvalidArgumentError::class);
        self::$client->zAdd($key, ['nx'], $score, $member);
    }

    /**
     * @throws RedisException
     */
    public function testZRevRangeWithScores(): void
    {
        $key = uniqid();
        $member1 = uniqid();
        $member2 = uniqid();
        $score1 = 1.0;
        $score2 = 2.0;

        $result = self::$client->zAdd($key, $score1, $member1, $score2, $member2);
        $this->assertEquals(2, $result, "Failed to add multiple members with scores");

        $elements = self::$client->zRevRange($key, 0, 2, true);
        $this->assertEquals([$member2 => $score2, $member1 => $score1], $elements, "Retrieved elements do not match the added elements");
    }

    /**
     * @throws RedisException
     */
    public function testZRevRangeWithoutScores(): void
    {
        $key = uniqid();
        $member1 = uniqid();
        $member2 = uniqid();
        $score1 = 1.0;
        $score2 = 2.0;

        $result = self::$client->zAdd($key, $score1, $member1, $score2, $member2);
        $this->assertEquals(2, $result, "Failed to add multiple members with scores");

        $elements = self::$client->zRevRange($key, 0, 2);
        $this->assertEquals([$member2, $member1], $elements, "Retrieved elements do not match the added elements");
    }

    /**
     * @throws RedisException
     */
    public function testZRevRangeWithValidRanks(): void
    {
        $key = uniqid();
        $member1 = uniqid();
        $member2 = uniqid();
        $member3 = uniqid();
        $score1 = 1.0;
        $score2 = 2.0;
        $score3 = 3.0;

        $result = self::$client->zAdd($key, $score1, $member1, $score2, $member2, $score3, $member3);
        $this->assertEquals(3, $result, "Failed to add multiple members with scores");

        // Test valid rank range with positive start and end
        $elements = self::$client->zRevRange($key, 0, 2);
        $this->assertEquals([$member3, $member2, $member1], $elements, "Elements do not match expected order for positive ranks");

        // Test valid rank range with negative start and end
        $elements = self::$client->zRevRange($key, -3, -1);
        $this->assertEquals([$member3, $member2, $member1], $elements, "Elements do not match expected order for negative ranks");

        // Test valid rank range with positive start and negative end
        $elements = self::$client->zRevRange($key, 0, -1);
        $this->assertEquals([$member3, $member2, $member1], $elements, "Elements do not match expected order for mixed ranks");

         // Test valid rank range with a subset of elements
        $elements = self::$client->zRevRange($key, 1, 2);
        $this->assertEquals([$member2, $member1], $elements, "Elements do not match expected order for a subset of elements");
    }

    /**
     * @throws RedisException
     */
    public function testZRevRangeWithInvalidRanks(): void
    {
        $key = uniqid();
        $member1 = uniqid();
        $member2 = uniqid();
        $score1 = 1.0;
        $score2 = 2.0;

        $result = self::$client->zAdd($key, $score1, $member1, $score2, $member2);
        $this->assertEquals(2, $result, "Failed to add multiple members with scores");

        // Test with start greater than end for positive ranks
        $result = self::$client->zRevRange($key, 2, 1);
        $this->assertEmpty($result, "Expected empty array for invalid ranks");

        // Test with start greater than end for negative ranks
        $result = self::$client->zRevRange($key, -1, -2);
        $this->assertEmpty($result, "Expected empty array for invalid ranks");
    }

    /**
     * @throws RedisException
     */
    public function testZRevRangeWhenSortedSetDoesNotExist(): void
    {
        $key = uniqid();
        $result = self::$client->zRevRange($key, 0, 1);
        $this->assertEmpty($result, "Expected empty array for non-existent key");
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
