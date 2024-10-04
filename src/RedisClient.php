<?php

namespace Momento\Cache;

use Redis;
use RedisException;

class RedisClient implements ICacheClient
{
    protected Redis $redis;

    public function __construct($redis)
    {
        $this->redis = $redis;
    }

    /**
     * @throws RedisException
     */
    public function set(string $cacheName, string $key, string $value, int $ttlSeconds = null): bool|Redis
    {
        return $this->redis->set($key, $value, $ttlSeconds);
    }

    /**
     * @throws RedisException
     */
    public function get(string $cacheName, string $key)
    {
        return $this->redis->get($key);
    }

    /**
     * @throws RedisException
     */
    public function flushDB(): bool|Redis
    {
        return $this->redis->flushDB();
    }

    /**
     * @throws RedisException
     */
    public function close(): bool
    {
        return $this->redis->close();
    }
}
