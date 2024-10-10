<?php

namespace Momento\Cache\Utils;

use Exception;
use Momento\Cache\Errors\NotImplementedException;

class MomentoToPhpRedisExceptionMapper
{
    public static function createCommandNotImplementedException(string $command): Exception
    {
        return new NotImplementedException("Command not implemented: $command");
    }
}
