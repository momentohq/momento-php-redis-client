<?php

namespace Momento\Cache\Utils;

use Exception;
use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\Errors\NotImplementedException;

class MomentoToPhpRedisExceptionMapper
{
    public static function createCommandNotImplementedException(string $command): Exception
    {
        return new NotImplementedException("Command not implemented: $command");
    }

    public static function createArgumentNotSupportedException(string $commandName, string $argumentName): InvalidArgumentError
    {
        return new InvalidArgumentError("Argument not supported for command $commandName: $argumentName");
    }
}
