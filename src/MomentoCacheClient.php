<?php

namespace Momento\Cache;

use Momento\Cache\Errors\NotImplementedException;
use Redis;

class MomentoCacheClient extends Redis implements IMomentoRedisClient
{
    protected CacheClient $client;
    protected string $cacheName;

    public function __construct(CacheClient $client, string $cacheName)
    {
        parent::__construct();
        $this->client = $client;
        $this->cacheName = $cacheName;
    }

    public function append(string $key, mixed $value): Redis|int|false
    {
        throw new NotImplementedException("Append is not implemented");
    }

    public function get(string $key): string|bool
    {
        $result = $this->client->get($this->cacheName, $key);
        if ($result->asHit()) {
            return $result->asHit()->valueString();
        } else {
            return false;
        }
    }

    public function set(string $key, mixed $value, mixed $options = null): Redis|bool
    {
        $result = $this->client->set($this->cacheName, $key, $value, $options);
        if ($result->asSuccess()) {
            return true;
        } else {
            return false;
        }
    }
}
