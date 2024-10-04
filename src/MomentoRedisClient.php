<?php

namespace Momento\Cache;

class MomentoRedisClient
{
    protected ICacheClient $cacheClient;
    protected string $cacheName;

    public function __construct(ICacheClient $cacheClient, string $cacheName)
    {
        $this->cacheClient = $cacheClient;
        $this->cacheName = $cacheName;
    }

    public function set(string $key, string $value, int $ttlSeconds = null): bool
    {
        return $this->cacheClient->set($this->cacheName, $key, $value, $ttlSeconds);
    }

    public function get(string $key): string|bool
    {
        return $this->cacheClient->get($this->cacheName, $key);
    }

    public function flushDB()
    {
        return $this->cacheClient->flushDB();
    }

    public function close()
    {
        return $this->cacheClient->close();
    }
}
