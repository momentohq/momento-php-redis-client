<?php

namespace Momento\Cache;

use Exception;
use Momento\Auth\EnvMomentoTokenProvider;
use Momento\Config\Configurations\Laptop;
use Momento\Cache\Errors\InvalidArgumentError;

class MomentoCacheClient implements ICacheClient
{
    protected CacheClient $client;

    /**
     * @throws InvalidArgumentError
     */
    public function __construct(string $cacheName, int $defaultTtl)
    {
        $authProvider = new EnvMomentoTokenProvider('MOMENTO_API_KEY');
        $configuration = Laptop::latest();
        $this->client = new CacheClient($configuration, $authProvider, $defaultTtl);
    }

    public function set(string $cacheName, string $key, string $value, int $ttlSeconds = null): bool
    {
        $result = $this->client->set($cacheName, $key, $value, $ttlSeconds);
        if ($result->asSuccess()) {
            return true;
        } else {
            return false;
        }
    }

    public function get(string $cacheName, string $key): string|bool
    {
        $result = $this->client->get($cacheName, $key);
        if ($result->asHit()) {
            return $result->asHit()->valueString();
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function flushDB()
    {
        throw new Exception('Not implemented');
    }

    /**
     * @throws Exception
     */
    public function close()
    {
        throw new Exception('Not implemented');
    }
}
