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
    public function testZCountWithValidRange(): void
    {
        $key = uniqid();
        $member1 = uniqid();
        $member2 = uniqid();
        $score1 = 1.0;
        $score2 = 2.0;

        // Add members to the sorted set
        self::$client->zAdd($key, $score1, $member1, $score2, $member2);

        // Count members in the range [1.0, 2.0]
        $count = self::$client->zCount($key, 1.0, 2.0);
        $this->assertEquals(2, $count, "Expected count of 2 for range [1.0, 2.0]");

        // Count members in the range (1.0, 2.0), exclusive of 1.0
        $count = self::$client->zCount($key, "(1.0", 2.0);
        $this->assertEquals(1, $count, "Expected count of 1 for range (1.0, 2.0)");

        // Count members in the range (1.0, (2.0), exclusive of both 1.0 and 2.0
        $count = self::$client->zCount($key, "(1.0", "(2.0");
        $this->assertEquals(0, $count, "Expected count of 0 for range (1.0, (2.0)");
    }

    /**
     * @throws RedisException
     */
    public function testZCountWithNonExistentKey(): void
    {
        $key = 'non_existent_key';

        // Count members in a non-existent key
        $count = self::$client->zCount($key, 1.0, 2.0);
        $this->assertEquals(0, $count, "Expected count of 0 for a non-existent key");
    }

    /**
     * @throws RedisException
     */
    public function testZCountWithInvalidRange(): void
    {
        $key = uniqid();
        $member = uniqid();
        $score = 1.0;

        // Add member to the sorted set
        self::$client->zAdd($key, $score, $member);

        // Try to count members with an invalid range
        $count = self::$client->zCount($key, "invalid", 2.0);
        $this->assertFalse($count, "Expected false for an invalid start range");

        $count = self::$client->zCount($key, 1.0, "invalid");
        $this->assertFalse($count, "Expected false for an invalid end range");
    }

    /**
     * @throws RedisException
     */
    public function testZCountWithInclusiveExclusiveRanges(): void
    {
        $key = uniqid();
        $member1 = uniqid();
        $member2 = uniqid();
        $score1 = 1.0;
        $score2 = 2.0;

        // Add members to the sorted set
        self::$client->zAdd($key, $score1, $member1, $score2, $member2);

        // Count members with inclusive start and exclusive end
        $count = self::$client->zCount($key, "1", "(2");
        $this->assertEquals(1, $count, "Expected count of 1 for range [1, 2)");

        // Count members with exclusive start and inclusive end
        $count = self::$client->zCount($key, "(1", "2");
        $this->assertEquals(1, $count, "Expected count of 1 for range (1, 2]");
    }

    /**
     * @throws RedisException
     */
    public function testZCountWithOpenEndedRanges(): void
    {
        $key = uniqid();
        $member1 = uniqid();
        $member2 = uniqid();
        $member3 = uniqid();
        $score1 = 1.0;
        $score2 = 2.0;
        $score3 = 3.0;

        // Add members to the sorted set
        self::$client->zAdd($key, $score1, $member1, $score2, $member2, $score3, $member3);

        // Count all members from -inf to +inf
        $count = self::$client->zCount($key, "-inf", "+inf");
        $this->assertEquals(3, $count, "Expected count of 3 for range -inf to +inf");

        // Count members from 2.0 to +inf
        $count = self::$client->zCount($key, 2.0, "+inf");
        $this->assertEquals(2, $count, "Expected count of 2 for range [2.0, +inf)");

        // Count members from -inf to 2.0
        $count = self::$client->zCount($key, "-inf", 2.0);
        $this->assertEquals(2, $count, "Expected count of 2 for range [-inf, 2.0]");
    }

    /**
     * @throws RedisException
     */
    public function testZCountWithMissedKeyAndErrorHandling(): void
    {
        $key = uniqid();

        // Count for a key that doesn't exist
        $result = self::$client->zCount($key, 1.0, 2.0);
        $this->assertEquals(0, $result, "Expected count 0 of a non-existent key");

        // Simulate an error condition
        $result = self::$client->zCount("", 1.0, 2.0);
        $this->assertEquals(0, $result, "Expected 0 for an empty key");
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
    public function testZRevRangeWithAllRanks(): void
    {
        $key = uniqid();
        $member1 = uniqid();
        $member2 = uniqid();
        $member3 = uniqid();
        $member4 = uniqid();
        $score1 = 1.0;
        $score2 = 2.0;
        $score3 = 3.0;
        $score4 = 4.0;

        $result = self::$client->zAdd($key, $score1, $member1, $score2, $member2, $score3, $member3, $score4, $member4);
        $this->assertEquals(4, $result, "Failed to add multiple members with scores");

        // Test 1: Both start and end are positive, start < end
        $elements = self::$client->zRevRange($key, 0, 2);
        $this->assertCount(3, $elements, "Expected 3 elements for range 0-2");
        $this->assertEquals([$member4, $member3, $member2], $elements, "Retrieved elements do not match the expected elements");

        // Test 2: Both start and end are positive, start == end
        $elements = self::$client->zRevRange($key, 1, 1);
        $this->assertCount(1, $elements, "Expected 1 element for range 1-1");

        // Test 3: Both start and end are positive, start > end
        $elements = self::$client->zRevRange($key, 2, 0);
        $this->assertEmpty($elements, "Expected empty array for range 2-0");

        // Test 4: Both start and end are negative, start < end
        $elements = self::$client->zRevRange($key, -3, -1);
        $this->assertCount(3, $elements, "Expected to fetch 3 elements for negative range -3 to -1");
        $this->assertEquals([$member3, $member2, $member1], $elements, "Retrieved elements do not match the expected elements for negative range");

        // Test 5: Both start and end are negative, start == end
        $elements = self::$client->zRevRange($key, -2, -2);
        $this->assertCount(1, $elements, "Expected 1 element for negative range -2 to -2");
        $this->assertEquals([$member2], $elements, "Retrieved elements do not match the expected elements for negative range");

        // Test 6: Both start and end are negative, start > end
        $elements = self::$client->zRevRange($key, -1, -3);
        $this->assertCount(0, $elements, "Expected to fetch 0 elements for invalid range -1 to -3");

        // Test 7: Mixed positive and negative ranks, start positive and end negative
        $elements = self::$client->zRevRange($key, 0, -2);
        $this->assertCount(3, $elements, "Expected to fetch 3 elements for mixed range 0 to -2");
        $this->assertEquals([$member4, $member3, $member2], $elements, "Retrieved elements do not match the expected elements for mixed range");

        // Test 8: Mixed positive and negative ranks, start negative and end positive
        $elements = self::$client->zRevRange($key, -3, 2);
        $this->assertCount(2, $elements, "Expected to fetch 2 elements for mixed range -3 to 2");
        $this->assertEquals([$member3, $member2], $elements, "Retrieved elements do not match the expected elements for mixed range");

        // Test 9: Unbounded end, should fetch all elements
        $elements = self::$client->zRevRange($key, 0, -1);
        $this->assertCount(4, $elements, "Expected to fetch all elements with unbounded end");
        $this->assertEquals([$member4, $member3, $member2, $member1], $elements, "Elements do not match expected order for unbounded end");
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
     * @throws RedisException
     */
    public function testZIncrByWhenKeyExists(): void
    {
        $key = uniqid();
        $member = uniqid();
        $score = 1.0;

        $result = self::$client->zAdd($key, $score, $member);
        $this->assertEquals(1, $result, "Failed to add member with score");

        $incrScore = 2.0;
        $newScore = self::$client->zIncrBy($key, $incrScore, $member);
        $this->assertEquals($score + $incrScore, $newScore, "Failed to increment the score");

        $elements = self::$client->zRevRange($key, 0, 1, true);
        $this->assertEquals([$member => $score + $incrScore], $elements, "Retrieved elements do not match the added elements");
    }

    /**
     * @throws RedisException
     */
    public function testZIncrByWhenKeyDoesNotExist(): void
    {
        $key = uniqid();
        $member = uniqid();
        $incrScore = 2.0;

        $newScore = self::$client->zIncrBy($key, $incrScore, $member);
        $this->assertEquals($incrScore, $newScore, "Failed to increment the score");

        $elements = self::$client->zRevRange($key, 0, 1, true);
        $this->assertEquals([$member => $incrScore], $elements, "Retrieved elements do not match the added elements");
    }

    /**
     * @throws RedisException
     */
    public function testZRemOnMissingKey(): void
    {
        $key = uniqid();
        $member = uniqid();
        $result = self::$client->zRem($key, $member);

        if (self::$isRedisBackendTest) {
            $this->assertEquals(0, $result, "Expected 0 for missing key");
        } else {
            $this->assertEquals(1, $result, "Expected 1 for missing key");
        }
    }

    /**
     * @throws RedisException
     */
    public function testZRemOnMissingMember(): void
    {
        $key = uniqid();
        $member = uniqid();
        $score = 1.0;
        self::$client->zAdd($key, $score, $member);

        $missingMember = uniqid();
        $result = self::$client->zRem($key, $missingMember);
        if (self::$isRedisBackendTest) {
            $this->assertEquals(0, $result, "Expected 0 for missing member");
        } else {
            $this->assertEquals(1, $result, "Expected 1 for missing member");
        }
    }

    /**
     * @throws RedisException
     */
    public function testZRemOnExistingMember(): void
    {
        $key = uniqid();
        $member = uniqid();
        $score = 1.0;
        self::$client->zAdd($key, $score, $member);

        $result = self::$client->zRem($key, $member);
        $this->assertEquals(1, $result, "Failed to remove the member");

        $elements = self::$client->zRevRange($key, 0, 1, true);
        $this->assertEmpty($elements, "Expected empty array after removing the member");
    }

    public function testZRemOnMultipleMembers(): void
    {
        $key = uniqid();
        $member1 = uniqid();
        $member2 = uniqid();
        $score1 = 1.0;
        $score2 = 2.0;
        $result = self::$client->zAdd($key, $score1, $member1, $score2, $member2);

        $result = self::$client->zRem($key, $member1, $member2);
        $this->assertEquals(2, $result, "Failed to remove multiple members");

        $elements = self::$client->zRevRange($key, 0, 1, true);
        $this->assertEmpty($elements, "Expected empty array after removing the members");
    }

    /**
     * @throws RedisException
     */
    public function testZScoreOnMissingKey(): void
    {
        $key = uniqid();
        $member = uniqid();
        $result = self::$client->zScore($key, $member);
        $this->assertFalse($result, "Expected false for missing key");
    }

    /**
     * @throws RedisException
     */
    public function testZScoreOnMissingMember(): void
    {
        $key = uniqid();
        $member = uniqid();
        $score = 1.0;
        self::$client->zAdd($key, $score, $member);

        $missingMember = uniqid();
        $result = self::$client->zScore($key, $missingMember);
        $this->assertFalse($result, "Expected false for missing member");
    }

    /**
     * @throws RedisException
     */
    public function testZScoreOnExistingMember(): void
    {
        $key = uniqid();
        $member = uniqid();
        $score = 1.0;
        self::$client->zAdd($key, $score, $member);

        $result = self::$client->zScore($key, $member);
        $this->assertEquals($score, $result, "Retrieved score does not match the expected score");
    }

    public function testZunionstore_WithDefaultWeightsAndSumAggregation(): void
    {
        $key1 = uniqid();
        $key2 = uniqid();
        $dst = uniqid();

        // Set up sorted sets
        self::$client->zAdd($key1, 1.0, 'a', 2.0, 'b');
        self::$client->zAdd($key2, 2.0, 'a', 3.0, 'c');

        // Perform zunionstore with default weights and sum aggregation
        $result = self::$client->zunionstore($dst, [$key1, $key2]);

        // Validate result count
        $this->assertEquals(3, $result, "zunionstore should return the correct count of unioned elements");

        // Validate the content of the destination set
        $storedValues = self::$client->zRevRange($dst, 0, -1, true);
        $expected = [
            'a' => 3.0,  // 1.0 from key1 and 2.0 from key2
            'c' => 3.0,
            'b' => 2.0,
        ];
        $this->assertEquals($expected, $storedValues, "The stored result in $dst should match the expected values.");
    }

    public function testZunionstore_WithProvidedWeightsAndSumAggregation(): void
    {
        $key1 = uniqid();
        $key2 = uniqid();
        $dst = uniqid();

        // Set up sorted sets
        self::$client->zAdd($key1, 1.0, 'a', 2.0, 'b');
        self::$client->zAdd($key2, 2.0, 'a', 3.0, 'c');

        // Perform zunionstore with provided weights
        $weights = [2.0, 3.0];  // Apply different weights to each sorted set
        $result = self::$client->zunionstore($dst, [$key1, $key2], $weights);

        // Validate result count
        $this->assertEquals(3, $result, "zunionstore should return the correct count of unioned elements");

        // Validate the content of the destination set
        $storedValues = self::$client->zRevRange($dst, 0, -1, true);
        $expected = [
            'a' => 8.0,  // (1.0 * 2.0) from key1 + (2.0 * 3.0) from key2
            'c' => 9.0,  // 3.0 from key2 * 3.0 weight
            'b' => 4.0,  // 2.0 from key1 * 2.0 weight
        ];
        $this->assertEquals($expected, $storedValues, "The stored result in $dst should match the expected values.");
    }

    public function testZunionstore_WithMaxAggregation(): void
    {
        $key1 = uniqid();
        $key2 = uniqid();
        $dst = uniqid();

        // Set up sorted sets
        self::$client->zAdd($key1, 1.0, 'a', 2.0, 'b');
        self::$client->zAdd($key2, 2.0, 'a', 3.0, 'b', 4.0, 'c');

        // Perform zunionstore with max aggregation
        $result = self::$client->zunionstore($dst, [$key1, $key2], null, 'max');

        // Validate result count
        $this->assertEquals(3, $result, "zunionstore should return the correct count of unioned elements");

        // Validate the content of the destination set
        $storedValues = self::$client->zRevRange($dst, 0, -1, true);
        $expected = [
            'c' => 4.0,
            'b' => 3.0,  // max(2.0 from key1, 3.0 from key2)
            'a' => 2.0,  // max(1.0 from key1, 2.0 from key2)
        ];
        $this->assertEquals($expected, $storedValues, "The stored result in $dst should match the expected max values.");
    }

    public function testZunionstore_WithMinAggregation(): void
    {
        $key1 = uniqid();
        $key2 = uniqid();
        $dst = uniqid();

        // Set up sorted sets
        self::$client->zAdd($key1, 1.0, 'a', 2.0, 'b');
        self::$client->zAdd($key2, 2.0, 'a', 3.0, 'b', 4.0, 'c');

        // Perform zunionstore with min aggregation
        $result = self::$client->zunionstore($dst, [$key1, $key2], null, 'min');

        // Validate result count
        $this->assertEquals(3, $result, "zunionstore should return the correct count of unioned elements");

        // Validate the content of the destination set
        $storedValues = self::$client->zRevRange($dst, 0, -1, true);
        $expected = [
            'c' => 4.0,  // No other value to compare to
            'b' => 2.0,  // min(2.0 from key1, 3.0 from key2)
            'a' => 1.0,  // min(1.0 from key1, 2.0 from key2)
        ];
        $this->assertEquals($expected, $storedValues, "The stored result in $dst should match the expected min values.");
    }

    public function testZunionstore_WithInvalidWeights_ShouldReturnFalse(): void
    {
        // Temporarily suppress warnings for this test: needed to suppress warnings on redis test
        $originalErrorReporting = error_reporting(E_ALL & ~E_WARNING);

        $key1 = uniqid();
        $key2 = uniqid();
        $dst = uniqid();

        // Set up sorted sets
        self::$client->zAdd($key1, 1.0, 'a');
        self::$client->zAdd($key2, 2.0, 'b');

        // Attempt zunionstore with invalid weights (mismatched count)
        $result = self::$client->zunionstore($dst, [$key1, $key2], [1.0]);
        $this->assertFalse($result);

        // Restore the original error reporting level
        error_reporting($originalErrorReporting);
    }

    public function testZunionstore_WithInvalidAggregate_ShouldReturnFalse(): void
    {
        // Temporarily suppress warnings for this test: needed to suppress warnings on redis test
        $originalErrorReporting = error_reporting(E_ALL & ~E_WARNING);

        $key1 = uniqid();
        $key2 = uniqid();
        $dst = uniqid();

        // Set up sorted sets
        self::$client->zAdd($key1, 1.0, 'a');
        self::$client->zAdd($key2, 2.0, 'b');

        // Attempt zunionstore with an invalid aggregate function
        $result = self::$client->zunionstore($dst, [$key1, $key2], null, 'invalid_aggregate');
        $this->assertFalse($result);


        // Restore the original error reporting level
        error_reporting($originalErrorReporting);
    }

    public function testZunionstore_WithEmptySortedSets_ShouldReturnZero(): void
    {
        $key1 = uniqid();
        $key2 = uniqid();
        $dst = uniqid();

        // No elements added to sorted sets

        // Perform zunionstore on empty sets
        $result = self::$client->zunionstore($dst, [$key1, $key2]);

        $this->assertEquals(0, $result, "zunionstore should return 0 when no elements are present in the union.");

        // Validate that the destination set is empty
        $storedValues = self::$client->zRevRange($dst, 0, -1, true);
        $this->assertEmpty($storedValues, "Destination set should be empty.");
    }

    /**
     * @throws RedisException
     */
    public function testZRevRangeByScore(): void
    {
        $key = uniqid();
        $member1 = uniqid();
        $member2 = uniqid();
        $member3 = uniqid();
        $member4 = uniqid();
        $score1 = 1.0;
        $score2 = 2.0;
        $score3 = 3.0;
        $score4 = 4.0;

        $result = self::$client->zAdd($key, $score1, $member1, $score2, $member2, $score3, $member3, $score4, $member4);
        $this->assertEquals(4, $result, "Failed to add multiple members with scores");

        // Test 1: Both min and max are inclusive
        $elements = self::$client->zRevRangeByScore($key, $score3, $score1);
        $this->assertCount(3, $elements, "Expected 3 elements for range 3-1");
        $this->assertEquals([$member3, $member2, $member1], $elements, "Elements do not match expected order");

        // Test 2: Both min and max are exclusive
        $elements = self::$client->zRevRangeByScore($key, "($score3", "($score1");
        $this->assertCount(1, $elements, "Expected 1 element for exclusive range (3-1)");
        $this->assertEquals([$member2], $elements, "Elements do not match expected result for exclusive range");

        // Test 3: With WITHSCORES option
        // Test 3.1: First way to get the elements with scores
        $elementsWithScores = self::$client->zRevRangeByScore($key, $score4, $score1, ['withscores' => true]);
        $this->assertCount(4, $elementsWithScores, "Expected 4 elements with scores for range 4-1");
        $expectedWithScores = [$member4 => $score4, $member3 => $score3, $member2 => $score2, $member1 => $score1];
        $this->assertEquals($expectedWithScores, $elementsWithScores, "Elements with scores do not match expected values");

        // Test 3.2: Second way to get the elements with scores
        $elements = self::$client->zRevRangeByScore($key, $score3, $score1, true);
        $this->assertCount(3, $elements, "Expected 3 elements for range 3-1 with scores");
        $this->assertEquals([$member3 => $score3, $member2 => $score2, $member1 => $score1], $elements, "Retrieved elements do not match the added elements");

        // Test 4: Without WITHSCORES option
        $elements = self::$client->zRevRangeByScore($key, $score3, $score1, false);
        $this->assertCount(3, $elements, "Expected 3 elements for range 3-1 with scores");
        $this->assertEquals([$member3, $member2, $member1], $elements, "Retrieved elements do not match the added elements");

        // Test 5: Range with negative infinity (-inf)
        $elements = self::$client->zRevRangeByScore($key, '+inf', '-inf');
        $this->assertCount(4, $elements, "Expected 4 elements for range +inf to -inf");
        $this->assertEquals([$member4, $member3, $member2, $member1], $elements, "Elements do not match expected result for +inf to -inf");

        // Test 6: Applying LIMIT option (fetch first 2 elements)
        $elements = self::$client->zRevRangeByScore($key, $score4, $score1, ['limit' => [0, 2]]);
        $this->assertCount(2, $elements, "Expected 2 elements for limit 2");
        $this->assertEquals([$member4, $member3], $elements, "Elements do not match expected result with LIMIT");

        // Test 7: Min greater than Max (invalid range)
        $elements = self::$client->zRevRangeByScore($key, $score1, $score3);
        $this->assertEmpty($elements, "Expected empty array for invalid range");
    }

    /**
     * @throws RedisException
     */
    public function testZRevRangeByScoreOnMissingKey(): void
    {
        $key = uniqid();
        $result = self::$client->zRevRangeByScore($key, 0, 1);
        $this->assertEmpty($result, "Expected empty array for non-existent key");
    }

    /**
     * @throws RedisException
     */
    public function testExistsForSingleAndMultipleKeys(): void {
        $key1 = uniqid();
        $value1 = uniqid();
        $key2 = uniqid();
        $value2 = uniqid();
        $key3 = uniqid();
        $value3 = uniqid();

        self::$client->set($key1, $value1);
        self::$client->set($key2, $value2);
        self::$client->set($key3, $value3);

        $exists = self::$client->exists($key1);
        $this->assertEquals(1, $exists, "Expected 1 for an existing key");

        $exists = self::$client->exists($key1, $key2, $key3);
        $this->assertEquals(3, $exists, "Expected 3 for an existing key");
    }

    /**
     * @throws RedisException
     */
    public function testExistsForMultipleKeysWithMissingKey(): void {
        $key1 = uniqid();
        $value1 = uniqid();
        $key2 = uniqid();
        $value2 = uniqid();
        $key3 = uniqid();

        self::$client->set($key1, $value1);
        self::$client->set($key2, $value2);

        $exists = self::$client->exists($key1, $key2, $key3);
        $this->assertEquals(2, $exists, "Expected 2 for two existing keys");
    }

    /**
     * @throws RedisException
     */
    public function testExistsOnNonExistingKey()
    {
        $exists = self::$client->exists(uniqid());
        $this->assertEquals(0, $exists, "Expected 0 for a non-existent key");
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
