<?php

namespace Momento\Cache\Utils;

use DI\NotFoundException;
use Exception;
use Momento\Cache\Errors\BadRequestError;
use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\Errors\NotImplementedException;
use Momento\Cache\Errors\SdkError;
use Momento\Cache\Errors\TimeoutError;
use RedisException;

class MomentoToPhpRedisExceptionMapper
{
    /**
     * @throws RedisException
     */
    public static function mapException(SdkError $sdkError): bool|RedisException
    {
        return match (get_class($sdkError)) {
            TimeoutError::class => throw new RedisException("Timeout occurred: " . $sdkError->getMessage()),
            default => false,
        };
    }

    public static function createCommandNotImplementedException(string $command): Exception
    {
        return new NotImplementedException("Command not implemented: $command");
    }

    public static function createArgumentNotSupportedException(string $commandName, string $argumentName): InvalidArgumentError
    {
        return new InvalidArgumentError("Argument not supported for command $commandName: $argumentName");
    }
}
