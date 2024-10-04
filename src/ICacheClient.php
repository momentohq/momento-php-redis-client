<?php

namespace Momento\Cache;

interface ICacheClient
{
    public function set(string $cacheName, string $key, string $value, int $ttlSeconds = null);
    public function get(string $cacheName, string $key);

    public function flushDB();
    public function close();
}
