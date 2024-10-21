<?php

namespace Momento\Cache;

use Redis;

interface IMomentoRedisClient
{
    public function del(array|string $key, string ...$other_keys): Redis|int|false;
    public function expire(string $key, int $timeout, ?string $mode = null): Redis|bool;
    public function get(string $key): mixed;
    public function incrBy(string $key, int $value): Redis|int|false;
    public function set(string $key, string $value, mixed $options = null): mixed;
    public function setnx(string $key, mixed $value): Redis|bool;
    public function ttl(string $key): Redis|int|false;
    public function zAdd(string $key, float|array $score_or_options, mixed ...$more_scores_and_mems): Redis|int|float|false;
    public function zRem(mixed $key, mixed $member, mixed ...$other_members): Redis|int|false;
    public function zRevRange(string $key, int $start, int $end, mixed $scores = null): Redis|array|false;
    public function zScore(string $key, mixed $member): Redis|float|false;
}
