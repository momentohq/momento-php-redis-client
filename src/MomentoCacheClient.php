<?php

namespace Momento\Cache;

use Exception;
use Momento\Cache\Utils\MomentoToPhpRedisExceptionMapper;
use Redis;
use TypeError;

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

    /**
     * @throws Exception
     */
    public function _compress(string $value): string
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function _uncompress(string $value): string
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function _prefix(string $key): string
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function _serialize(mixed $value): string
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function _unserialize(string $value): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function _pack(mixed $value): string
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function _unpack(string $value): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function acl(string $subcmd, string ...$args): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function append(string $key, mixed $value): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function auth(#[\SensitiveParameter] mixed $credentials): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function bgSave(): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function bgrewriteaof(): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function waitaof(int $numlocal, int $numreplicas, int $timeout): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function bitcount(string $key, int $start = 0, int $end = -1, bool $bybit = false): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function bitop(string $operation, string $deskey, string $srckey, string ...$other_keys): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function bitpos(string $key, bool $bit, int $start = 0, int $end = -1, bool $bybit = false): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function blPop(string|array $key_or_keys, string|float|int $timeout_or_key, mixed ...$extra_args): Redis|array|null|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function brPop(string|array $key_or_keys, string|float|int $timeout_or_key, mixed ...$extra_args): Redis|array|null|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function brpoplpush(string $src, string $dst, int|float $timeout): Redis|string|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function bzPopMax(string|array $key, string|int $timeout_or_key, mixed ...$extra_args): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function bzPopMin(string|array $key, string|int $timeout_or_key, mixed ...$extra_args): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function bzmpop(float $timeout, array $keys, string $from, int $count = 1): Redis|array|null|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zmpop(array $keys, string $from, int $count = 1): Redis|array|null|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function blmpop(float $timeout, array $keys, string $from, int $count = 1): Redis|array|null|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lmpop(array $keys, string $from, int $count = 1): Redis|array|null|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function clearLastError(): bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function client(string $opt, mixed ...$args): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function close(): bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function command(?string $opt = null, mixed ...$args): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function config(string $operation, array|string|null $key_or_settings = null, ?string $value = null): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function connect(
        string $host,
        int $port = 6379,
        float $timeout = 0,
        ?string $persistent_id = null,
        int $retry_interval = 0,
        float $read_timeout = 0,
        ?array $context = null
    ): bool {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function copy(string $src, string $dst, ?array $options = null): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function dbSize(): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function debug(string $key): Redis|string
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function decr(string $key, int $by = 1): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function decrBy(string $key, int $value): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }


    public function del(array|string $key, string ...$other_keys): Redis|int|false
    {
        if (is_array($key)) {
            $keys = $key;
        } else {
            $keys = array_merge([$key], $other_keys);
        }
        foreach ($keys as $key) {
            $result = $this->client->delete($this->cacheName, $key);
            if ($result->asError()) {
                return MomentoToPhpRedisExceptionMapper::mapExceptionElseReturnFalse($result);
            }
        }
        return count($keys);
    }

    /**
     * @throws Exception
     */
    public function delete(array|string $key, string ...$other_keys): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function discard(): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function dump(string $key): Redis|string|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function echo(string $str): Redis|string|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function eval(string $script, array $args = [], int $num_keys = 0): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function eval_ro(string $script_sha, array $args = [], int $num_keys = 0): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function evalsha(string $sha1, array $args = [], int $num_keys = 0): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function evalsha_ro(string $sha1, array $args = [], int $num_keys = 0): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function exec(): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function exists(mixed $key, mixed ...$other_keys): Redis|int|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function expire(string $key, int $timeout, ?string $mode = null): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function expireAt(string $key, int $timestamp, ?string $mode = null): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function failover(?array $to = null, bool $abort = false, int $timeout = 0): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function expiretime(string $key): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function pexpiretime(string $key): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function fcall(string $fn, array $keys = [], array $args = []): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function fcall_ro(string $fn, array $keys = [], array $args = []): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function flushAll(?bool $sync = null): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function flushDB(?bool $sync = null): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function function(string $operation, mixed ...$args): Redis|bool|string|array
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function geoadd(string $key, float $lng, float $lat, string $member, mixed ...$other_triples_and_options): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function geodist(string $key, string $src, string $dst, ?string $unit = null): Redis|float|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function geohash(string $key, string $member, string ...$other_members): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function geopos(string $key, string $member, string ...$other_members): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function georadius(string $key, float $lng, float $lat, float $radius, string $unit, array $options = []): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function georadius_ro(string $key, float $lng, float $lat, float $radius, string $unit, array $options = []): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function georadiusbymember(string $key, string $member, float $radius, string $unit, array $options = []): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function georadiusbymember_ro(string $key, string $member, float $radius, string $unit, array $options = []): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function geosearch(string $key, array|string $position, array|int|float $shape, string $unit, array $options = []): array
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function geosearchstore(string $dst, string $src, array|string $position, array|int|float $shape, string $unit, array $options = []): Redis|array|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    public function get(string $key): mixed
    {
        $result = $this->client->get($this->cacheName, $key);
        if ($result->asHit()) {
            return $result->asHit()->valueString();
        } else {
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function getAuth(): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getBit(string $key, int $idx): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getEx(string $key, array $options = []): Redis|string|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getDBNum(): int
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getDel(string $key): Redis|string|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getHost(): string
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getLastError(): ?string
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getMode(): int
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getOption(int $option): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getPersistentID(): ?string
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getPort(): int
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getRange(string $key, int $start, int $end): Redis|string|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lcs(string $key1, string $key2, ?array $options = null): Redis|string|array|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getReadTimeout(): float
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getset(string $key, mixed $value): Redis|string|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getTimeout(): float|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function getTransferredBytes(): array
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function clearTransferredBytes(): void
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hDel(string $key, string $field, string ...$other_fields): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hExists(string $key, string $field): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hGet(string $key, string $member): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hGetAll(string $key): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hIncrBy(string $key, string $field, int $value): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hIncrByFloat(string $key, string $field, float $value): Redis|float|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hKeys(string $key): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hLen(string $key): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hMget(string $key, array $fields): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hMset(string $key, array $fieldvals): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hRandField(string $key, ?array $options = null): Redis|string|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hSet(string $key, mixed ...$fields_and_vals): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hSetNx(string $key, string $field, mixed $value): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hStrLen(string $key, string $field): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hVals(string $key): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function hscan(string $key, null|int|string &$iterator, ?string $pattern = null, int $count = 0): Redis|array|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function incr(string $key, int $by = 1): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    public function incrBy(string $key, int $value): Redis|int|false
    {
        $result = $this->client->increment($this->cacheName, $key, $value);
        if ($result->asSuccess()) {
            return $result->asSuccess()->value();
        } else {
            return MomentoToPhpRedisExceptionMapper::mapExceptionElseReturnFalse($result);
        }
    }

    /**
     * @throws Exception
     */
    public function incrByFloat(string $key, float $value): Redis|float|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function info(string ...$sections): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function isConnected(): bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function keys(string $pattern)
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lInsert(string $key, string $pos, mixed $pivot, mixed $value)
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lLen(string $key): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lMove(string $src, string $dst, string $wherefrom, string $whereto): Redis|string|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function blmove(string $src, string $dst, string $wherefrom, string $whereto, float $timeout): Redis|string|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lPop(string $key, int $count = 0): Redis|bool|string|array
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lPos(string $key, mixed $value, ?array $options = null): Redis|null|bool|int|array
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lPush(string $key, mixed ...$elements): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function rPush(string $key, mixed ...$elements): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lPushx(string $key, mixed $value): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function rPushx(string $key, mixed $value): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lSet(string $key, int $index, mixed $value): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lastSave(): int
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lindex(string $key, int $index): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lrange(string $key, int $start, int $end): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function lrem(string $key, mixed $value, int $count = 0): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function ltrim(string $key, int $start, int $end): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function mget(array $keys): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function migrate(
        string $host,
        int $port,
        string|array $key,
        int $dstdb,
        int $timeout,
        bool $copy = false,
        bool $replace = false,
        #[\SensitiveParameter] mixed $credentials = null
    ): Redis|bool {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function move(string $key, int $index): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function mset(array $key_values): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function msetnx(array $key_values): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function multi(int $value = Redis::MULTI): bool|Redis
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function object(string $subcommand, string $key): Redis|int|string|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function open(string $host, int $port = 6379, float $timeout = 0, ?string $persistent_id = null, int $retry_interval = 0, float $read_timeout = 0, ?array $context = null): bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function pconnect(string $host, int $port = 6379, float $timeout = 0, ?string $persistent_id = null, int $retry_interval = 0, float $read_timeout = 0, ?array $context = null): bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function persist(string $key): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function pexpire(string $key, int $timeout, ?string $mode = null): bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function pexpireAt(string $key, int $timestamp, ?string $mode = null): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function pfadd(string $key, array $elements): Redis|int
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function pfcount(array|string $key_or_keys): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function pfmerge(string $dst, array $srckeys): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function ping(?string $message = null): Redis|string|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function pipeline(): bool|Redis
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function popen(string $host, int $port = 6379, float $timeout = 0, ?string $persistent_id = null, int $retry_interval = 0, float $read_timeout = 0, ?array $context = null): bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function psetex(string $key, int $expire, mixed $value): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function psubscribe(array $patterns, callable $cb): bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function pttl(string $key): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function publish(string $channel, string $message): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function pubsub(string $command, mixed $arg = null): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function punsubscribe(array $patterns): Redis|array|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function rPop(string $key, int $count = 0): Redis|array|string|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function randomKey(): Redis|string|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function rawcommand(string $command, mixed ...$args): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function rename(string $old_name, string $new_name): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function renameNx(string $key_src, string $key_dst): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function reset(): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function restore(string $key, int $ttl, string $value, ?array $options = null): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function role(): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function rpoplpush(string $srckey, string $dstkey): Redis|string|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sAdd(string $key, mixed $value, mixed ...$other_values): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sAddArray(string $key, array $values): int
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sDiff(string $key, string ...$other_keys): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sDiffStore(string $dst, string $key, string ...$other_keys): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sInter(array|string $key, string ...$other_keys): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sintercard(array $keys, int $limit = -1): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sInterStore(array|string $key, string ...$other_keys): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sMembers(string $key): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sMisMember(string $key, string $member, string ...$other_members): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sMove(string $src, string $dst, mixed $value): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sPop(string $key, int $count = 0): Redis|string|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sRandMember(string $key, int $count = 0): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sUnion(string $key, string ...$other_keys): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sUnionStore(string $dst, string $key, string ...$other_keys): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function save(): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function scan(null|int|string &$iterator, ?string $pattern = null, int $count = 0, ?string $type = null): array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function scard(string $key): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function script(string $command, mixed ...$args): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function select(int $db): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function set(string $key, mixed $value, mixed $options = null): Redis|string|bool
    {
        if (is_numeric($value)) {
            $value = (string)$value;
        }

        $ttl = null;

        if (is_array($options)) {
            $options = array_change_key_case($options, CASE_LOWER);

            // Handle different TTL options (EX, PX, EXAT, PXAT)
            if (isset($options['ex'])) {
                $ttl = $options['ex'];
            } elseif (isset($options['px'])) {
                $ttl = $options['px'] / 1000;
            } elseif (isset($options['exat'])) {
                $ttl = $options['exat'] - time();
            } elseif (isset($options['pxat'])) {
                $ttl = floor(($options['pxat'] - microtime(true) * 1000) / 1000);
            } elseif (isset($options['keepttl'])) {
                throw MomentoToPhpRedisExceptionMapper::createArgumentNotSupportedException('set', 'keepttl');
            }

            // Handle NX option: Set if the key does not exist
            if (in_array('nx', $options, true)) {
                $result = $this->client->setIfAbsent($this->cacheName, $key, $value, $ttl);
                if ($result->asStored()) {
                    return "OK";
                } else if ($result->asNotStored()) {
                    return false;
                } else {
                    return MomentoToPhpRedisExceptionMapper::mapExceptionElseReturnFalse($result);
                }
            } elseif (in_array('xx', $options, true)) {
                // Handle XX option: Set only if the key already exists
                $result = $this->client->setIfPresent($this->cacheName, $key, $value, $ttl);
                if ($result->asStored()) {
                    return "OK";
                } else if ($result->asNotStored()) {
                    return false;
                } else {
                    return MomentoToPhpRedisExceptionMapper::mapExceptionElseReturnFalse($result);
                }
            }

            // Handle GET option: Return exception
            if (in_array('get', $options, true)) {
                throw MomentoToPhpRedisExceptionMapper::createArgumentNotSupportedException('set', 'get');
            }
        }

        // Execute the set command on the cache with the provided TTL
        $result = $this->client->set($this->cacheName, $key, $value, $ttl);
        if ($result->asSuccess()) {
            return 'OK';
        } else {
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function setBit(string $key, int $idx, bool $value): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function setRange(string $key, int $index, string $value): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function setOption(int $option, mixed $value): bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function setex(string $key, int $expire, mixed $value)
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function setnx(string $key, mixed $value): Redis|bool
    {
        $result = $this->client->setIfAbsent($this->cacheName, $key, $value);
        if ($result->asStored()) {
            return true;
        } else if ($result->asNotStored()) {
            return false;
        } else {
            return MomentoToPhpRedisExceptionMapper::mapExceptionElseReturnFalse($result);
        }
    }

    /**
     * @throws Exception
     */
    public function sismember(string $key, mixed $value): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function slaveof(?string $host = null, int $port = 6379): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function replicaof(?string $host = null, int $port = 6379): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function touch(array|string $key_or_array, string ...$more_keys): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function slowlog(string $operation, int $length = 0): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sort(string $key, ?array $options = null): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sort_ro(string $key, ?array $options = null): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sortAsc(string $key, ?string $pattern = null, mixed $get = null, int $offset = -1, int $count = -1, ?string $store = null): array
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sortAscAlpha(string $key, ?string $pattern = null, mixed $get = null, int $offset = -1, int $count = -1, ?string $store = null): array
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sortDesc(string $key, ?string $pattern = null, mixed $get = null, int $offset = -1, int $count = -1, ?string $store = null): array
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sortDescAlpha(string $key, ?string $pattern = null, mixed $get = null, int $offset = -1, int $count = -1, ?string $store = null): array
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function srem(string $key, mixed $value, mixed ...$other_values): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sscan(string $key, null|int|string &$iterator, ?string $pattern = null, int $count = 0): array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function ssubscribe(array $channels, callable $cb): bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function strlen(string $key): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function subscribe(array $channels, callable $cb): bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function sunsubscribe(array $channels): Redis|array|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function swapdb(int $src, int $dst): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function time(): Redis|array
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function ttl(string $key): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function type(string $key): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function unlink(array|string $key, string ...$other_keys): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function unsubscribe(array $channels): Redis|array|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function unwatch(): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function watch(array|string $key, string ...$other_keys): Redis|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function wait(int $numreplicas, int $timeout): int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xack(string $key, string $group, array $ids): int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xadd(string $key, string $id, array $values, int $maxlen = 0, bool $approx = false, bool $nomkstream = false): Redis|string|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xautoclaim(string $key, string $group, string $consumer, int $min_idle, string $start, int $count = -1, bool $justid = false): Redis|bool|array
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xclaim(string $key, string $group, string $consumer, int $min_idle, array $ids, array $options): Redis|array|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xdel(string $key, array $ids): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xgroup(
        string $operation,
        ?string $key = null,
        ?string $group = null,
        ?string $id_or_consumer = null,
        bool $mkstream = false,
        int $entries_read = -2
    ): mixed {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xinfo(string $operation, ?string $arg1 = null, ?string $arg2 = null, int $count = -1): mixed
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xlen(string $key): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xpending(string $key, string $group, ?string $start = null, ?string $end = null, int $count = -1, ?string $consumer = null): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xrange(string $key, string $start, string $end, int $count = -1): Redis|array|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xread(array $streams, int $count = -1, int $block = -1): Redis|array|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xreadgroup(string $group, string $consumer, array $streams, int $count = 1, int $block = 1): Redis|array|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xrevrange(string $key, string $end, string $start, int $count = -1): Redis|array|bool
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function xtrim(string $key, string $threshold, bool $approx = false, bool $minid = false, int $limit = -1): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zAdd(string $key, array|float $score_or_options, mixed ...$more_scores_and_mems): Redis|int|float|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zCard(string $key): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zCount(string $key, int|string $start, int|string $end): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zIncrBy(string $key, float $value, mixed $member): Redis|float|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zLexCount(string $key, string $min, string $max): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zMscore(string $key, mixed $member, mixed ...$other_members): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zPopMax(string $key, ?int $count = null): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zPopMin(string $key, ?int $count = null): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRange(string $key, string|int $start, string|int $end, array|bool|null $options = null): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRangeByLex(string $key, string $min, string $max, int $offset = -1, int $count = -1): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRangeByScore(string $key, string $start, string $end, array $options = []): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zrangestore(
        string $dstkey,
        string $srckey,
        string $start,
        string $end,
        array|bool|null $options = null
    ): Redis|int|false {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRandMember(string $key, ?array $options = null): Redis|string|array
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRank(string $key, mixed $member): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRem(mixed $key, mixed $member, mixed ...$other_members): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRemRangeByLex(string $key, string $min, string $max): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRemRangeByRank(string $key, int $start, int $end): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRemRangeByScore(string $key, string $start, string $end): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRevRange(string $key, int $start, int $end, mixed $scores = null): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRevRangeByLex(string $key, string $max, string $min, int $offset = -1, int $count = -1): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRevRangeByScore(string $key, string $max, string $min, array|bool $options = []): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zRevRank(string $key, mixed $member): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zScore(string $key, mixed $member): Redis|float|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zdiff(array $keys, ?array $options = null): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zdiffstore(string $dst, array $keys): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zinter(array $keys, ?array $weights = null, ?array $options = null): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zintercard(array $keys, int $limit = -1): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zinterstore(string $dst, array $keys, ?array $weights = null, ?string $aggregate = null): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zscan(string $key, null|int|string &$iterator, ?string $pattern = null, int $count = 0): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zunion(array $keys, ?array $weights = null, ?array $options = null): Redis|array|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }

    /**
     * @throws Exception
     */
    public function zunionstore(string $dst, array $keys, ?array $weights = null, ?string $aggregate = null): Redis|int|false
    {
        throw MomentoToPhpRedisExceptionMapper::createCommandNotImplementedException(__FUNCTION__);
    }
}
