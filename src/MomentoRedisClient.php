<?php

namespace Momento\Cache;

use Exception;
use Momento\Auth\EnvMomentoTokenProvider;
use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Config\Configurations\Laptop;

class MomentoRedisClient
{
    protected CacheClient $client;
    protected string $cacheName;

    /**
     * @throws InvalidArgumentError
     */
    public function __construct(string $cacheName, int $defaultTtl)
    {
        $authProvider = new EnvMomentoTokenProvider
        ('MOMENTO_API_KEY');
        $configuration = Laptop::latest();
        $this->client = new CacheClient($configuration, $authProvider, $defaultTtl);
        $this->cacheName = $cacheName;
    }

    /**
     * @throws Exception
     */
    public function set(string $key, string $value, int $ttlSeconds = null)
    {
        $response = $this->client->set($this->cacheName, $key, $value, $ttlSeconds);
        if ($response->asSuccess()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function get(string $key)
    {
        $response = $this->client->get($this->cacheName, $key);
        if ($response->asHit()) {
            return $response->asHit()->valueString();
        } elseif ($response->asMiss()) {
            return false;
        } else {
            return false;
        }
    }
}
