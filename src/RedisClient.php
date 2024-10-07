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

    public function _compress(string $value): string
    {
        return $this->redis->_compress($value);
    }

    public function _uncompress(string $value): string
    {
        return $this->redis->_uncompress($value);
    }

    /**
     * @throws RedisException
     */
    public function _prefix(string $key): string
    {
        return $this->redis->_prefix($key);
    }

    public function _serialize(mixed $value): string
    {
        return $this->redis->_serialize($value);
    }

    public function _unserialize(string $value): mixed
    {
        return $this->redis->_unserialize($value);
    }

    public function _pack(mixed $value): string
    {
        return $this->redis->_pack($value);
    }

    public function _unpack(string $value): mixed
    {
        return $this->redis->_unpack($value);
    }

    /**
     * @throws RedisException
     */
    public function append(string $key, mixed $value): Redis|int|false
    {
        return $this->redis->append($key, $value);
    }

    /**
     * @throws RedisException
     */
    public function auth(#[\SensitiveParameter] mixed $credentials): Redis|bool
    {
        return $this->redis->auth($credentials);
    }

    /**
     * @throws RedisException
     */
    public function bgSave(): Redis|bool
    {
        return $this->redis->bgSave();
    }

    /**
     * @throws RedisException
     */
    public function bgrewriteaof(): Redis|bool
    {
        return $this->redis->bgrewriteaof();
    }

    public function waitaof(int $numlocal, int $numreplicas, int $timeout): Redis|array|false
    {
        return $this->redis->waitaof($numlocal, $numreplicas, $timeout);
    }

    /**
     * @throws RedisException
     */
    public function bitcount(string $key, int $start = 0, int $end = -1, bool $bybit = false): Redis|int|false
    {
        return $this->redis->bitcount($key, $start, $end, $bybit);
    }

    /**
     * @throws RedisException
     */
    public function bitpos(string $key, bool $bit, int $start = 0, int $end = -1, bool $bybit = false): Redis|int|false
    {
        return $this->redis->bitpos($key, $bit, $start, $end, $bybit);
    }

    /**
     * @throws RedisException
     */
    public function blPop(array|string $key_or_keys, float|int|string $timeout_or_key, ...$extra_args): Redis|array|null|false
    {
        return $this->redis->blPop($key_or_keys, $timeout_or_key, ...$extra_args);
    }

    /**
     * @throws RedisException
     */
    public function brPop(array|string $key_or_keys, float|int|string $timeout_or_key, ...$extra_args): Redis|array|null|false
    {
        return $this->redis->brPop($key_or_keys, $timeout_or_key, ...$extra_args);
    }

    /**
     * @throws RedisException
     */
    public function brpoplpush(string $src, string $dst, float|int $timeout): Redis|string|false
    {
        return $this->redis->brpoplpush($src, $dst, $timeout);
    }

    /**
     * @throws RedisException
     */
    public function bzPopMax(array|string $key, int|string $timeout_or_key, ...$extra_args): Redis|array|false
    {
        return $this->redis->bzPopMax($key, $timeout_or_key, ...$extra_args);
    }

    /**
     * @throws RedisException
     */
    public function bzPopMin(array|string $key, int|string $timeout_or_key, ...$extra_args): Redis|array|false
    {
        return $this->redis->bzPopMin($key, $timeout_or_key, ...$extra_args);
    }

    public function bzmpop(float $timeout, array $keys, string $from, int $count = 1): Redis|array|null|false
    {
        return $this->redis->bzmpop($timeout, $keys, $from, $count);
    }

    public function zmpop(array $keys, string $from, int $count = 1): Redis|array|null|false
    {
        return $this->redis->zmpop($keys, $from, $count);
    }

    public function blmpop(float $timeout, array $keys, string $from, int $count = 1): Redis|array|null|false
    {
        return $this->redis->blmpop($timeout, $keys, $from, $count);
    }

    public function lmpop(array $keys, string $from, int $count = 1): Redis|array|null|false
    {
        return $this->redis->lmpop($keys, $from, $count);
    }

    /**
     * @throws RedisException
     */
    public function clearLastError(): bool
    {
        return $this->redis->clearLastError();
    }

    /**
     * @throws RedisException
     */
    public function config(string $operation, array|string|null $key_or_settings = null, ?string $value = null): mixed
    {
        return $this->redis->config($operation, $key_or_settings, $value);
    }

    public function copy(string $src, string $dst, ?array $options = null): Redis|bool
    {
        return $this->redis->copy($src, $dst, $options);
    }

    /**
     * @throws RedisException
     */
    public function dbSize(): Redis|int|false
    {
        return $this->redis->dbSize();
    }

    /**
     * @throws RedisException
     */
    public function decr(string $key, int $by = 1): Redis|int|false
    {
        return $this->redis->decr($key, $by);
    }

    /**
     * @throws RedisException
     */
    public function decrBy(string $key, int $value): Redis|int|false
    {
        return $this->redis->decrBy($key, $value);
    }

    /**
     * @throws RedisException
     */
    public function del(array|string $key, string ...$other_keys): Redis|int|false
    {
        return $this->redis->del($key, ...$other_keys);
    }

    /**
     * @throws RedisException
     */
    public function delete(array|string $key, string ...$other_keys): Redis|int|false
    {
        return $this->redis->delete($key, ...$other_keys);
    }

    /**
     * @throws RedisException
     */
    public function discard(): Redis|bool
    {
        return $this->redis->discard();
    }

    /**
     * @throws RedisException
     */
    public function dump(string $key): Redis|string|false
    {
        return $this->redis->dump($key);
    }

    /**
     * @throws RedisException
     */
    public function echo(string $str): Redis|string|false
    {
        return $this->redis->echo($str);
    }

    /**
     * @throws RedisException
     */
    public function eval(string $script, array $args = [], int $num_keys = 0): mixed
    {
        return $this->redis->eval($script, $args, $num_keys);
    }

    public function eval_ro(string $script_sha, array $args = [], int $num_keys = 0): mixed
    {
        return $this->redis->eval_ro($script_sha, $args, $num_keys);
    }

    /**
     * @throws RedisException
     */
    public function evalsha(string $sha1, array $args = [], int $num_keys = 0): mixed
    {
        return $this->redis->evalsha($sha1, $args, $num_keys);
    }

    public function evalsha_ro(string $sha1, array $args = [], int $num_keys = 0): mixed
    {
        return $this->redis->evalsha_ro($sha1, $args, $num_keys);
    }

    /**
     * @throws RedisException
     */
    public function exec(): Redis|array|false
    {
        return $this->redis->exec();
    }

    /**
     * @throws RedisException
     */
    public function exists(mixed $key, ...$other_keys): Redis|int|bool
    {
        return $this->redis->exists($key, ...$other_keys);
    }

    /**
     * @throws RedisException
     */
    public function expire(string $key, int $timeout, ?string $mode = null): Redis|bool
    {
        return $this->redis->expire($key, $timeout, $mode);
    }

    /**
     * @throws RedisException
     */
    public function expireAt(string $key, int $timestamp, ?string $mode = null): Redis|bool
    {
        return $this->redis->expireAt($key, $timestamp, $mode);
    }

    public function expiretime(string $key): Redis|int|false
    {
        return $this->redis->expiretime($key);
    }

    public function pexpiretime(string $key): Redis|int|false
    {
        return $this->redis->pexpiretime($key);
    }

    public function fcall(string $fn, array $keys = [], array $args = []): mixed
    {
        return $this->redis->fcall($fn, $keys, $args);
    }

    public function fcall_ro(string $fn, array $keys = [], array $args = []): mixed
    {
        return $this->redis->fcall_ro($fn, $keys, $args);
    }

    /**
     * @throws RedisException
     */
    public function flushAll(?bool $sync = null): Redis|bool
    {
        return $this->redis->flushAll($sync);
    }

    /**
     * @throws RedisException
     */
    public function flushDB(?bool $sync = null): Redis|bool
    {
        return $this->redis->flushDB($sync);
    }

    public function function (string $operation, ...$args): Redis|bool|string|array
    {
        return $this->redis->function ($operation, ...$args);
    }

    /**
     * @throws RedisException
     */
    public function geoadd(string $key, float $lng, float $lat, string $member, ...$other_triples_and_options): Redis|int|false
    {
        return $this->redis->geoadd($key, $lng, $lat, $member, ...$other_triples_and_options);
    }

    /**
     * @throws RedisException
     */
    public function geodist(string $key, string $src, string $dst, ?string $unit = null): Redis|float|false
    {
        return $this->redis->geodist($key, $src, $dst, $unit);
    }

    /**
     * @throws RedisException
     */
    public function geohash(string $key, string $member, string ...$other_members): Redis|array|false
    {
        return $this->redis->geohash($key, $member, ...$other_members);
    }

    /**
     * @throws RedisException
     */
    public function geopos(string $key, string $member, string ...$other_members): Redis|array|false
    {
        return $this->redis->geopos($key, $member, ...$other_members);
    }

    /**
     * @throws RedisException
     */
    public function georadius(string $key, float $lng, float $lat, float $radius, string $unit, array $options = []): mixed
    {
        return $this->redis->georadius($key, $lng, $lat, $radius, $unit, $options);
    }

    public function georadius_ro(string $key, float $lng, float $lat, float $radius, string $unit, array $options = []): mixed
    {
        return $this->redis->georadius_ro($key, $lng, $lat, $radius, $unit, $options);
    }

    /**
     * @throws RedisException
     */
    public function georadiusbymember(string $key, string $member, float $radius, string $unit, array $options = []): mixed
    {
        return $this->redis->georadiusbymember($key, $member, $radius, $unit, $options);
    }

    public function georadiusbymember_ro(string $key, string $member, float $radius, string $unit, array $options = []): mixed
    {
        return $this->redis->georadiusbymember_ro($key, $member, $radius, $unit, $options);
    }

    public function geosearch(string $key, array|string $position, float|array|int $shape, string $unit, array $options = []): array
    {
        return $this->redis->geosearch($key, $position, $shape, $unit, $options);
    }

    public function geosearchstore(string $dst, string $src, array|string $position, float|array|int $shape, string $unit, array $options = []): Redis|array|int|false
    {
        return $this->redis->geosearchstore($dst, $src, $position, $shape, $unit, $options);
    }

    /**
     * @throws RedisException
     */
    public function get(string $key): mixed
    {
        return $this->redis->get($key);
    }

    /**
     * @throws RedisException
     */
    public function getAuth(): mixed
    {
        return $this->redis->getAuth();
    }

    /**
     * @throws RedisException
     */
    public function getBit(string $key, int $idx): Redis|int|false
    {
        return $this->redis->getBit($key, $idx);
    }

    public function getEx(string $key, array $options = []): Redis|string|bool
    {
        return $this->redis->getEx($key, $options);
    }

    /**
     * @throws RedisException
     */
    public function getDBNum(): int
    {
        return $this->redis->getDBNum();
    }

    public function getDel(string $key): Redis|string|bool
    {
        return $this->redis->getDel($key);
    }

    /**
     * @throws RedisException
     */
    public function getHost(): string
    {
        return $this->redis->getHost();
    }

    /**
     * @throws RedisException
     */
    public function getLastError(): string
    {
        return $this->redis->getLastError();
    }

    /**
     * @throws RedisException
     */
    public function getMode(): int
    {
        return $this->redis->getMode();
    }

    /**
     * @throws RedisException
     */
    public function getOption(int $option): mixed
    {
        return $this->redis->getOption($option);
    }

    /**
     * @throws RedisException
     */
    public function getPersistentID(): string
    {
        return $this->redis->getPersistentID();
    }

    /**
     * @throws RedisException
     */
    public function getPort(): int
    {
        return $this->redis->getPort();
    }

    /**
     * @throws RedisException
     */
    public function getRange(string $key, int $start, int $end): Redis|string|false
    {
        return $this->redis->getRange($key, $start, $end);
    }

    public function lcs(string $key1, string $key2, ?array $options = null): Redis|string|array|int|false
    {
        return $this->redis->lcs($key1, $key2, $options);
    }

    /**
     * @throws RedisException
     */
    public function getReadTimeout(): float
    {
        return $this->redis->getReadTimeout();
    }

    /**
     * @throws RedisException
     */
    public function getset(string $key, mixed $value): Redis|string|false
    {
        return $this->redis->getset($key, $value);
    }

    /**
     * @throws RedisException
     */
    public function getTimeout(): float|false
    {
        return $this->redis->getTimeout();
    }

    public function getTransferredBytes(): array
    {
        return $this->redis->getTransferredBytes();
    }

    public function clearTransferredBytes(): void
    {
        $this->redis->clearTransferredBytes();
    }

    /**
     * @throws RedisException
     */
    public function hDel(string $key, string $field, string ...$other_fields): Redis|int|false
    {
        return $this->redis->hDel($key, $field, ...$other_fields);
    }

    /**
     * @throws RedisException
     */
    public function hExists(string $key, string $field): Redis|bool
    {
        return $this->redis->hExists($key, $field);
    }

    /**
     * @throws RedisException
     */
    public function hGetAll(string $key): Redis|array|false
    {
        return $this->redis->hGetAll($key);
    }

    /**
     * @throws RedisException
     */
    public function hIncrBy(string $key, string $field, int $value): Redis|int|false
    {
        return $this->redis->hIncrBy($key, $field, $value);
    }

    /**
     * @throws RedisException
     */
    public function hIncrByFloat(string $key, string $field, float $value): Redis|float|false
    {
        return $this->redis->hIncrByFloat($key, $field, $value);
    }

    /**
     * @throws RedisException
     */
    public function hKeys(string $key): Redis|array|false
    {
        return $this->redis->hKeys($key);
    }

    /**
     * @throws RedisException
     */
    public function hLen(string $key): Redis|int|false
    {
        return $this->redis->hLen($key);
    }

    /**
     * @throws RedisException
     */
    public function hMget(string $key, array $fields): Redis|array|false
    {
        return $this->redis->hMget($key, $fields);
    }

    /**
     * @throws RedisException
     */
    public function hMset(string $key, array $fieldvals): Redis|bool
    {
        return $this->redis->hMset($key, $fieldvals);
    }

    public function hRandField(string $key, ?array $options = null): Redis|string|array|false
    {
        return $this->redis->hRandField($key, $options);
    }

    /**
     * @throws RedisException
     */
    public function hSet(string $key, ...$fields_and_vals): Redis|int|false
    {
        return $this->redis->hSet($key, ...$fields_and_vals);
    }

    /**
     * @throws RedisException
     */
    public function hSetNx(string $key, string $field, mixed $value): Redis|bool
    {
        return $this->redis->hSetNx($key, $field, $value);
    }

    /**
     * @throws RedisException
     */
    public function hStrLen(string $key, string $field): Redis|int|false
    {
        return $this->redis->hStrLen($key, $field);
    }

    /**
     * @throws RedisException
     */
    public function hVals(string $key): Redis|array|false
    {
        return $this->redis->hVals($key);
    }

    /**
     * @throws RedisException
     */
    public function hscan(string $key, int|string|null &$iterator, ?string $pattern = null, int $count = 0): Redis|array|bool
    {
        return $this->redis->hscan($key, $iterator, $pattern, $count);
    }

    /**
     * @throws RedisException
     */
    public function incr(string $key, int $by = 1): Redis|int|false
    {
        return $this->redis->incr($key, $by);
    }

    /**
     * @throws RedisException
     */
    public function incrBy(string $key, int $value): Redis|int|false
    {
        return $this->redis->incrBy($key, $value);
    }

    /**
     * @throws RedisException
     */
    public function incrByFloat(string $key, float $value): Redis|float|false
    {
        return $this->redis->incrByFloat($key, $value);
    }

    /**
     * @throws RedisException
     */
    public function info(string ...$sections): Redis|array|false
    {
        return $this->redis->info(...$sections);
    }

    /**
     * @throws RedisException
     */
    public function isConnected(): bool
    {
        return $this->redis->isConnected();
    }

    /**
     * @throws RedisException
     */
    public function keys(string $pattern)
    {
        return $this->redis->keys($pattern);
    }

    /**
     * @throws RedisException
     */
    public function lInsert(string $key, string $pos, mixed $pivot, mixed $value)
    {
        return $this->redis->lInsert($key, $pos, $pivot, $value);
    }

    /**
     * @throws RedisException
     */
    public function lLen(string $key): Redis|int|false
    {
        return $this->redis->lLen($key);
    }

    public function lMove(string $src, string $dst, string $wherefrom, string $whereto): Redis|string|false
    {
        return $this->redis->lMove($src, $dst, $wherefrom, $whereto);
    }

    public function blmove(string $src, string $dst, string $wherefrom, string $whereto, float $timeout): Redis|string|false
    {
        return $this->redis->blmove($src, $dst, $wherefrom, $whereto, $timeout);
    }

    /**
     * @throws RedisException
     */
    public function lPop(string $key, int $count = 0): Redis|bool|string|array
    {
        return $this->redis->lPop($key, $count);
    }

    public function lPos(string $key, mixed $value, ?array $options = null): Redis|null|bool|int|array
    {
        return $this->redis->lPos($key, $value, $options);
    }

    /**
     * @throws RedisException
     */
    public function lPush(string $key, ...$elements): Redis|int|false
    {
        return $this->redis->lPush($key, ...$elements);
    }

    /**
     * @throws RedisException
     */
    public function rPush(string $key, ...$elements): Redis|int|false
    {
        return $this->redis->rPush($key, ...$elements);
    }

    /**
     * @throws RedisException
     */
    public function lPushx(string $key, mixed $value): Redis|int|false
    {
        return $this->redis->lPushx($key, $value);
    }

    /**
     * @throws RedisException
     */
    public function rPushx(string $key, mixed $value): Redis|int|false
    {
        return $this->redis->rPushx($key, $value);
    }

    /**
     * @throws RedisException
     */
    public function lSet(string $key, int $index, mixed $value): Redis|bool
    {
        return $this->redis->lSet($key, $index, $value);
    }

    /**
     * @throws RedisException
     */
    public function lastSave(): int
    {
        return $this->redis->lastSave();
    }

    /**
     * @throws RedisException
     */
    public function lindex(string $key, int $index): mixed
    {
        return $this->redis->lindex($key, $index);
    }

    /**
     * @throws RedisException
     */
    public function lrange(string $key, int $start, int $end): Redis|array|false
    {
        return $this->redis->lrange($key, $start, $end);
    }

    /**
     * @throws RedisException
     */
    public function lrem(string $key, mixed $value, int $count = 0): Redis|int|false
    {
        return $this->redis->lrem($key, $value, $count);
    }

    /**
     * @throws RedisException
     */
    public function ltrim(string $key, int $start, int $end): Redis|bool
    {
        return $this->redis->ltrim($key, $start, $end);
    }

    /**
     * @throws RedisException
     */
    public function mget(array $keys): Redis|array|false
    {
        return $this->redis->mget($keys);
    }

    /**
     * @throws RedisException
     */
    public function move(string $key, int $index): Redis|bool
    {
        return $this->redis->move($key, $index);
    }

    /**
     * @throws RedisException
     */
    public function mset(array $key_values): Redis|bool
    {
        return $this->redis->mset($key_values);
    }

    /**
     * @throws RedisException
     */
    public function msetnx(array $key_values): Redis|bool
    {
        return $this->redis->msetnx($key_values);
    }

    /**
     * @throws RedisException
     */
    public function multi(int $value = Redis::MULTI): bool|Redis
    {
        return $this->redis->multi($value);
    }

    /**
     * @throws RedisException
     */
    public function open(string $host, int $port = 6379, float $timeout = 0, ?string $persistent_id = null, int $retry_interval = 0, float $read_timeout = 0, ?array $context = null): bool
    {
        return $this->redis->open($host, $port, $timeout, $persistent_id, $retry_interval, $read_timeout, $context);
    }

    /**
     * @throws RedisException
     */
    public function persist(string $key): Redis|bool
    {
        return $this->redis->persist($key);
    }

    /**
     * @throws RedisException
     */
    public function pexpire(string $key, int $timeout, ?string $mode = null): bool
    {
        return $this->redis->pexpire($key, $timeout, $mode);
    }

    /**
     * @throws RedisException
     */
    public function pexpireAt(string $key, int $timestamp, ?string $mode = null): Redis|bool
    {
        return $this->redis->pexpireAt($key, $timestamp, $mode);
    }

    /**
     * @throws RedisException
     */
    public function pfadd(string $key, array $elements): Redis|int
    {
        return $this->redis->pfadd($key, $elements);
    }

    /**
     * @throws RedisException
     */
    public function pfcount(array|string $key_or_keys): Redis|int|false
    {
        return $this->redis->pfcount($key_or_keys);
    }

    /**
     * @throws RedisException
     */
    public function pfmerge(string $dst, array $srckeys): Redis|bool
    {
        return $this->redis->pfmerge($dst, $srckeys);
    }

    /**
     * @throws RedisException
     */
    public function ping(?string $message = null): Redis|string|bool
    {
        return $this->redis->ping($message);
    }

    /**
     * @throws RedisException
     */
    public function pipeline(): bool|Redis
    {
        return $this->redis->pipeline();
    }

    /**
     * @throws RedisException
     */
    public function popen(string $host, int $port = 6379, float $timeout = 0, ?string $persistent_id = null, int $retry_interval = 0, float $read_timeout = 0, ?array $context = null): bool
    {
        return $this->redis->popen($host, $port, $timeout, $persistent_id, $retry_interval, $read_timeout, $context);
    }

    /**
     * @throws RedisException
     */
    public function psetex(string $key, int $expire, mixed $value): Redis|bool
    {
        return $this->redis->psetex($key, $expire, $value);
    }

    /**
     * @throws RedisException
     */
    public function psubscribe(array $patterns, callable $cb): bool
    {
        return $this->redis->psubscribe($patterns, $cb);
    }

    /**
     * @throws RedisException
     */
    public function pttl(string $key): Redis|int|false
    {
        return $this->redis->pttl($key);
    }

    /**
     * @throws RedisException
     */
    public function publish(string $channel, string $message): Redis|int|false
    {
        return $this->redis->publish($channel, $message);
    }

    /**
     * @throws RedisException
     */
    public function punsubscribe(array $patterns): Redis|array|bool
    {
        return $this->redis->punsubscribe($patterns);
    }

    /**
     * @throws RedisException
     */
    public function rPop(string $key, int $count = 0): Redis|array|string|bool
    {
        return $this->redis->rPop($key, $count);
    }

    /**
     * @throws RedisException
     */
    public function randomKey(): Redis|string|false
    {
        return $this->redis->randomKey();
    }

    /**
     * @throws RedisException
     */
    public function rawcommand(string $command, ...$args): mixed
    {
        return $this->redis->rawcommand($command, ...$args);
    }

    /**
     * @throws RedisException
     */
    public function rename(string $old_name, string $new_name): Redis|bool
    {
        return $this->redis->rename($old_name, $new_name);
    }

    /**
     * @throws RedisException
     */
    public function renameNx(string $key_src, string $key_dst): Redis|bool
    {
        return $this->redis->renameNx($key_src, $key_dst);
    }

    public function reset(): Redis|bool
    {
        return $this->redis->reset();
    }

    /**
     * @throws RedisException
     */
    public function restore(string $key, int $ttl, string $value, ?array $options = null): Redis|bool
    {
        return $this->redis->restore($key, $ttl, $value, $options);
    }

    /**
     * @throws RedisException
     */
    public function role(): mixed
    {
        return $this->redis->role();
    }

    /**
     * @throws RedisException
     */
    public function rpoplpush(string $srckey, string $dstkey): Redis|string|false
    {
        return $this->redis->rpoplpush($srckey, $dstkey);
    }

    public function sAdd(string $key, mixed $value, ...$other_values): Redis|int|false
    {
        return $this->redis->sAdd($key, $value, ...$other_values);
    }

    /**
     * @throws RedisException
     */
    public function sAddArray(string $key, array $values): int
    {
        return $this->redis->sAddArray($key, $values);
    }

    /**
     * @throws RedisException
     */
    public function sDiff(string $key, string ...$other_keys): Redis|array|false
    {
        return $this->redis->sDiff($key, ...$other_keys);
    }

    /**
     * @throws RedisException
     */
    public function sDiffStore(string $dst, string $key, string ...$other_keys): Redis|int|false
    {
        return $this->redis->sDiffStore($dst, $key, ...$other_keys);
    }

    /**
     * @throws RedisException
     */
    public function sInter(array|string $key, string ...$other_keys): Redis|array|false
    {
        return $this->redis->sInter($key, ...$other_keys);
    }

    public function sintercard(array $keys, int $limit = -1): Redis|int|false
    {
        return $this->redis->sintercard($keys, $limit);
    }

    /**
     * @throws RedisException
     */
    public function sInterStore(array|string $key, string ...$other_keys): Redis|int|false
    {
        return $this->redis->sInterStore($key, ...$other_keys);
    }

    /**
     * @throws RedisException
     */
    public function sMembers(string $key): Redis|array|false
    {
        return $this->redis->sMembers($key);
    }

    public function sMisMember(string $key, string $member, string ...$other_members): Redis|array|false
    {
        return $this->redis->sMisMember($key, $member, ...$other_members);
    }

    /**
     * @throws RedisException
     */
    public function sMove(string $src, string $dst, mixed $value): Redis|bool
    {
        return $this->redis->sMove($src, $dst, $value);
    }

    /**
     * @throws RedisException
     */
    public function sPop(string $key, int $count = 0): Redis|string|array|false
    {
        return $this->redis->sPop($key, $count);
    }

    /**
     * @throws RedisException
     */
    public function sRandMember(string $key, int $count = 0): mixed
    {
        return $this->redis->sRandMember($key, $count);
    }

    /**
     * @throws RedisException
     */
    public function sUnion(string $key, string ...$other_keys): Redis|array|false
    {
        return $this->redis->sUnion($key, ...$other_keys);
    }

    /**
     * @throws RedisException
     */
    public function sUnionStore(string $dst, string $key, string ...$other_keys): Redis|int|false
    {
        return $this->redis->sUnionStore($dst, $key, ...$other_keys);
    }

    /**
     * @throws RedisException
     */
    public function save(): Redis|bool
    {
        return $this->redis->save();
    }

    /**
     * @throws RedisException
     */
    public function scan(int|string|null &$iterator, ?string $pattern = null, int $count = 0, ?string $type = null): array|false
    {
        return $this->redis->scan($iterator, $pattern, $count, $type);
    }

    /**
     * @throws RedisException
     */
    public function scard(string $key): Redis|int|false
    {
        return $this->redis->scard($key);
    }

    /**
     * @throws RedisException
     */
    public function script(string $command, ...$args): mixed
    {
        return $this->redis->script($command, ...$args);
    }

    /**
     * @throws RedisException
     */
    public function select(int $db): Redis|bool
    {
        return $this->redis->select($db);
    }

    /**
     * @throws RedisException
     */
    public function set(string $key, mixed $value, mixed $options = null): Redis|string|bool
    {
        return $this->redis->set($key, $value, $options);
    }

    /**
     * @throws RedisException
     */
    public function setBit(string $key, int $idx, bool $value): Redis|int|false
    {
        return $this->redis->setBit($key, $idx, $value);
    }

    /**
     * @throws RedisException
     */
    public function setRange(string $key, int $index, string $value): Redis|int|false
    {
        return $this->redis->setRange($key, $index, $value);
    }

    /**
     * @throws RedisException
     */
    public function setOption(int $option, mixed $value): bool
    {
        return $this->redis->setOption($option, $value);
    }

    /**
     * @throws RedisException
     */
    public function setex(string $key, int $expire, mixed $value)
    {
        return $this->redis->setex($key, $expire, $value);
    }

    /**
     * @throws RedisException
     */
    public function setnx(string $key, mixed $value): Redis|bool
    {
        return $this->redis->setnx($key, $value);
    }

    /**
     * @throws RedisException
     */
    public function sismember(string $key, mixed $value): Redis|bool
    {
        return $this->redis->sismember($key, $value);
    }

    /**
     * @throws RedisException
     */
    public function slaveof(?string $host = null, int $port = 6379): Redis|bool
    {
        return $this->redis->slaveof($host, $port);
    }

    public function replicaof(?string $host = null, int $port = 6379): Redis|bool
    {
        return $this->redis->replicaof($host, $port);
    }

    public function touch(array|string $key_or_array, string ...$more_keys): Redis|int|false
    {
        return $this->redis->touch($key_or_array, ...$more_keys);
    }

    /**
     * @throws RedisException
     */
    public function slowlog(string $operation, int $length = 0): mixed
    {
        return $this->redis->slowlog($operation, $length);
    }

    /**
     * @throws RedisException
     */
    public function sort(string $key, ?array $options = null): mixed
    {
        return $this->redis->sort($key, $options);
    }

    public function sort_ro(string $key, ?array $options = null): mixed
    {
        return $this->redis->sort_ro($key, $options);
    }

    public function sortAsc(string $key, ?string $pattern = null, mixed $get = null, int $offset = -1, int $count = -1, ?string $store = null): array
    {
        return $this->redis->sortAsc($key, $pattern, $get, $offset, $count, $store);
    }

    public function sortAscAlpha(string $key, ?string $pattern = null, mixed $get = null, int $offset = -1, int $count = -1, ?string $store = null): array
    {
        return $this->redis->sortAscAlpha($key, $pattern, $get, $offset, $count, $store);
    }

    public function sortDesc(string $key, ?string $pattern = null, mixed $get = null, int $offset = -1, int $count = -1, ?string $store = null): array
    {
        return $this->redis->sortDesc($key, $pattern, $get, $offset, $count, $store);
    }

    public function sortDescAlpha(string $key, ?string $pattern = null, mixed $get = null, int $offset = -1, int $count = -1, ?string $store = null): array
    {
        return $this->redis->sortDescAlpha($key, $pattern, $get, $offset, $count, $store);
    }

    public function srem(string $key, mixed $value, ...$other_values): Redis|int|false
    {
        return $this->redis->srem($key, $value, ...$other_values);
    }

    /**
     * @throws RedisException
     */
    public function sscan(string $key, int|string|null &$iterator, ?string $pattern = null, int $count = 0): array|false
    {
        return $this->redis->sscan($key, $iterator, $pattern, $count);
    }

    public function ssubscribe(array $channels, callable $cb): bool
    {
        return $this->redis->ssubscribe($channels, $cb);
    }

    /**
     * @throws RedisException
     */
    public function strlen(string $key): Redis|int|false
    {
        return $this->redis->strlen($key);
    }

    /**
     * @throws RedisException
     */
    public function subscribe(array $channels, callable $cb): bool
    {
        return $this->redis->subscribe($channels, $cb);
    }

    public function sunsubscribe(array $channels): Redis|array|bool
    {
        return $this->redis->sunsubscribe($channels);
    }

    /**
     * @throws RedisException
     */
    public function swapdb(int $src, int $dst): Redis|bool
    {
        return $this->redis->swapdb($src, $dst);
    }

    /**
     * @throws RedisException
     */
    public function time(): Redis|array
    {
        return $this->redis->time();
    }

    /**
     * @throws RedisException
     */
    public function ttl(string $key): Redis|int|false
    {
        return $this->redis->ttl($key);
    }

    /**
     * @throws RedisException
     */
    public function type(string $key): Redis|int|false
    {
        return $this->redis->type($key);
    }

    /**
     * @throws RedisException
     */
    public function unlink(array|string $key, string ...$other_keys): Redis|int|false
    {
        return $this->redis->unlink($key, ...$other_keys);
    }

    /**
     * @throws RedisException
     */
    public function unsubscribe(array $channels): Redis|array|bool
    {
        return $this->redis->unsubscribe($channels);
    }

    /**
     * @throws RedisException
     */
    public function unwatch(): Redis|bool
    {
        return $this->redis->unwatch();
    }

    /**
     * @throws RedisException
     */
    public function watch(array|string $key, string ...$other_keys): Redis|bool
    {
        return $this->redis->watch($key, ...$other_keys);
    }

    /**
     * @throws RedisException
     */
    public function wait(int $numreplicas, int $timeout): int|false
    {
        return $this->redis->wait($numreplicas, $timeout);
    }

    /**
     * @throws RedisException
     */
    public function xack(string $key, string $group, array $ids): int|false
    {
        return $this->redis->xack($key, $group, $ids);
    }

    /**
     * @throws RedisException
     */
    public function xadd(string $key, string $id, array $values, int $maxlen = 0, bool $approx = false, bool $nomkstream = false): Redis|string|false
    {
        return $this->redis->xadd($key, $id, $values, $maxlen, $approx, $nomkstream);
    }

    public function xautoclaim(string $key, string $group, string $consumer, int $min_idle, string $start, int $count = -1, bool $justid = false): Redis|bool|array
    {
        return $this->redis->xautoclaim($key, $group, $consumer, $min_idle, $start, $count, $justid);
    }

    /**
     * @throws RedisException
     */
    public function xclaim(string $key, string $group, string $consumer, int $min_idle, array $ids, array $options): Redis|array|bool
    {
        return $this->redis->xclaim($key, $group, $consumer, $min_idle, $ids, $options);
    }

    /**
     * @throws RedisException
     */
    public function xdel(string $key, array $ids): Redis|int|false
    {
        return $this->redis->xdel($key, $ids);
    }

    /**
     * @throws RedisException
     */
    public function xgroup(string $operation, ?string $key = null, ?string $group = null, ?string $id_or_consumer = null, bool $mkstream = false, int $entries_read = -2): mixed
    {
        return $this->redis->xgroup($operation, $key, $group, $id_or_consumer, $mkstream, $entries_read);
    }

    /**
     * @throws RedisException
     */
    public function xinfo(string $operation, ?string $arg1 = null, ?string $arg2 = null, int $count = -1): mixed
    {
        return $this->redis->xinfo($operation, $arg1, $arg2, $count);
    }

    /**
     * @throws RedisException
     */
    public function xlen(string $key): Redis|int|false
    {
        return $this->redis->xlen($key);
    }

    /**
     * @throws RedisException
     */
    public function xpending(string $key, string $group, ?string $start = null, ?string $end = null, int $count = -1, ?string $consumer = null): Redis|array|false
    {
        return $this->redis->xpending($key, $group, $start, $end, $count, $consumer);
    }

    /**
     * @throws RedisException
     */
    public function xrange(string $key, string $start, string $end, int $count = -1): Redis|array|bool
    {
        return $this->redis->xrange($key, $start, $end, $count);
    }

    /**
     * @throws RedisException
     */
    public function xread(array $streams, int $count = -1, int $block = -1): Redis|array|bool
    {
        return $this->redis->xread($streams, $count, $block);
    }

    /**
     * @throws RedisException
     */
    public function xreadgroup(string $group, string $consumer, array $streams, int $count = 1, int $block = 1): Redis|array|bool
    {
        return $this->redis->xreadgroup($group, $consumer, $streams, $count, $block);
    }

    /**
     * @throws RedisException
     */
    public function xrevrange(string $key, string $end, string $start, int $count = -1): Redis|array|bool
    {
        return $this->redis->xrevrange($key, $end, $start, $count);
    }

    public function xtrim(string $key, string $threshold, bool $approx = false, bool $minid = false, int $limit = -1): Redis|int|false
    {
        return $this->redis->xtrim($key, $threshold, $approx, $minid, $limit);
    }

    /**
     * @throws RedisException
     */
    public function zAdd(string $key, float|array $score_or_options, ...$more_scores_and_mems): Redis|int|float|false
    {
        return $this->redis->zAdd($key, $score_or_options, ...$more_scores_and_mems);
    }

    /**
     * @throws RedisException
     */
    public function zCard(string $key): Redis|int|false
    {
        return $this->redis->zCard($key);
    }

    /**
     * @throws RedisException
     */
    public function zCount(string $key, int|string $start, int|string $end): Redis|int|false
    {
        return $this->redis->zCount($key, $start, $end);
    }

    /**
     * @throws RedisException
     */
    public function zIncrBy(string $key, float $value, mixed $member): Redis|float|false
    {
        return $this->redis->zIncrBy($key, $value, $member);
    }

    public function zLexCount(string $key, string $min, string $max): Redis|int|false
    {
        return $this->redis->zLexCount($key, $min, $max);
    }

    public function zMscore(string $key, mixed $member, ...$other_members): Redis|array|false
    {
        return $this->redis->zMscore($key, $member, ...$other_members);
    }

    public function zPopMax(string $key, ?int $count = null): Redis|array|false
    {
        return $this->redis->zPopMax($key, $count);
    }

    public function zPopMin(string $key, ?int $count = null): Redis|array|false
    {
        return $this->redis->zPopMin($key, $count);
    }

    /**
     * @throws RedisException
     */
    public function zRange(string $key, int|string $start, int|string $end, bool|array|null $options = null): Redis|array|false
    {
        return $this->redis->zRange($key, $start, $end, $options);
    }

    /**
     * @throws RedisException
     */
    public function zRangeByLex(string $key, string $min, string $max, int $offset = -1, int $count = -1): Redis|array|false
    {
        return $this->redis->zRangeByLex($key, $min, $max, $offset, $count);
    }

    /**
     * @throws RedisException
     */
    public function zRangeByScore(string $key, string $start, string $end, array $options = []): Redis|array|false
    {
        return $this->redis->zRangeByScore($key, $start, $end, $options);
    }

    public function zrangestore(string $dstkey, string $srckey, string $start, string $end, bool|array|null $options = null): Redis|int|false
    {
        return $this->redis->zrangestore($dstkey, $srckey, $start, $end, $options);
    }

    public function zRandMember(string $key, ?array $options = null): Redis|string|array
    {
        return $this->redis->zRandMember($key, $options);
    }

    /**
     * @throws RedisException
     */
    public function zRank(string $key, mixed $member): Redis|int|false
    {
        return $this->redis->zRank($key, $member);
    }

    /**
     * @throws RedisException
     */
    public function zRem(mixed $key, mixed $member, ...$other_members): Redis|int|false
    {
        return $this->redis->zRem($key, $member, ...$other_members);
    }

    public function zRemRangeByLex(string $key, string $min, string $max): Redis|int|false
    {
        return $this->redis->zRemRangeByLex($key, $min, $max);
    }

    /**
     * @throws RedisException
     */
    public function zRemRangeByRank(string $key, int $start, int $end): Redis|int|false
    {
        return $this->redis->zRemRangeByRank($key, $start, $end);
    }

    /**
     * @throws RedisException
     */
    public function zRemRangeByScore(string $key, string $start, string $end): Redis|int|false
    {
        return $this->redis->zRemRangeByScore($key, $start, $end);
    }

    /**
     * @throws RedisException
     */
    public function zRevRange(string $key, int $start, int $end, mixed $scores = null): Redis|array|false
    {
        return $this->redis->zRevRange($key, $start, $end, $scores);
    }

    /**
     * @throws RedisException
     */
    public function zRevRangeByLex(string $key, string $max, string $min, int $offset = -1, int $count = -1): Redis|array|false
    {
        return $this->redis->zRevRangeByLex($key, $max, $min, $offset, $count);
    }

    /**
     * @throws RedisException
     */
    public function zRevRangeByScore(string $key, string $max, string $min, bool|array $options = []): Redis|array|false
    {
        return $this->redis->zRevRangeByScore($key, $max, $min, $options);
    }

    /**
     * @throws RedisException
     */
    public function zRevRank(string $key, mixed $member): Redis|int|false
    {
        return $this->redis->zRevRank($key, $member);
    }

    /**
     * @throws RedisException
     */
    public function zScore(string $key, mixed $member): Redis|float|false
    {
        return $this->redis->zScore($key, $member);
    }

    public function zdiff(array $keys, ?array $options = null): Redis|array|false
    {
        return $this->redis->zdiff($keys, $options);
    }

    public function zdiffstore(string $dst, array $keys): Redis|int|false
    {
        return $this->redis->zdiffstore($dst, $keys);
    }

    /**
     * @throws RedisException
     */
    public function zinter(array $keys, ?array $weights = null, ?array $options = null): Redis|array|false
    {
        return $this->redis->zinter($keys, $weights, $options);
    }

    public function zintercard(array $keys, int $limit = -1): Redis|int|false
    {
        return $this->redis->zintercard($keys, $limit);
    }

    /**
     * @throws RedisException
     */
    public function zinterstore(string $dst, array $keys, ?array $weights = null, ?string $aggregate = null): Redis|int|false
    {
        return $this->redis->zinterstore($dst, $keys, $weights, $aggregate);
    }

    /**
     * @throws RedisException
     */
    public function zscan(string $key, int|string|null &$iterator, ?string $pattern = null, int $count = 0): Redis|array|false
    {
        return $this->redis->zscan($key, $iterator, $pattern, $count);
    }

    /**
     * @throws RedisException
     */
    public function zunion(array $keys, ?array $weights = null, ?array $options = null): Redis|array|false
    {
        return $this->redis->zunion($keys, $weights, $options);
    }

    /**
     * @throws RedisException
     */
    public function zunionstore(string $dst, array $keys, ?array $weights = null, ?string $aggregate = null): Redis|int|false
    {
        return $this->redis->zunionstore($dst, $keys, $weights, $aggregate);
    }
}
