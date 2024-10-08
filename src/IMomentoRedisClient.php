<?php

namespace Momento\Cache;

interface IMomentoRedisClient
{
    /**
     * Set a value in the cache with an optional TTL (time-to-live).
     *
     * @param string $key Key under which the value is stored.
     * @param string $value Value to be stored.
     * @param mixed $options options Time-to-live for the key-value pair in seconds. If null, no expiration.
     * @return mixed Returns true on success or false on failure.
     */
    public function set(string $key, string $value, mixed $options = null): mixed;

    /**
     * Get a value from the cache.
     *
     * @param string $key Key whose value is to be retrieved.
     * @return mixed Returns the value stored in the cache, or false if the key does not exist.
     */
    public function get(string $key): mixed;
}
