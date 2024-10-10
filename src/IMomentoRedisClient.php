<?php

namespace Momento\Cache;

interface IMomentoRedisClient
{
    public function set(string $key, string $value, mixed $options = null): mixed;
    public function get(string $key): mixed;
}
