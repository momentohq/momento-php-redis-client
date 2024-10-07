<?php

namespace Momento\Cache;

use Redis;

class MomentoRedisClient
{
    protected ICacheClient $cacheClient;

    public function __construct(ICacheClient $cacheClient)
    {
        $this->cacheClient = $cacheClient;
    }

    public function set(string $key, string $value, int $ttlSeconds = null): bool
    {
        return $this->cacheClient->set($key, $value, $ttlSeconds);
    }

    public function get(string $key): string|bool
    {
        return $this->cacheClient->get($key);
    }

    public function flushDB(): bool|Redis
    {
        return $this->cacheClient->flushDB();
    }
}
