<?php

namespace Momento\Cache\Utils;

use Momento\Cache\Errors\InvalidArgumentError;
use Momento\Cache\Errors\NotImplementedException;
use Momento\Cache\Errors\TimeoutError;
use RedisException;

class MomentoToPhpRedisExceptionMapper
{
    /**
     * @throws RedisException
     */
    public static function mapExceptionElseReturnFalse($error, $apiName): bool|RedisException
    {
        $sdkError = $error->asError()->innerException();
        if (get_class($sdkError) === TimeoutError::class) {
            $errorDetails = "$apiName returned error {$sdkError->getMessage()}\n";
            throw new RedisException("Timeout occurred: " . $errorDetails);
        }
        return false;
    }

    public static function createCommandNotImplementedException(string $command): NotImplementedException
    {
        return new NotImplementedException("Command not implemented: $command");
    }

    public static function createArgumentNotSupportedException(string $commandName, string $argumentName): InvalidArgumentError
    {
        return new InvalidArgumentError("Argument not supported for command $commandName: $argumentName");
    }
}
