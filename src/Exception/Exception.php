<?php

namespace AppBundle\Exception;

class Exception extends \Exception implements ExceptionInterface
{
    public static function typeOf($arg)
    {
        if (is_object($arg)) {
            return get_class($arg);
        }

        if (is_resource($arg)) {
            return 'RESOURCE';
        }

        if (null === $arg) {
            return 'NULL';
        }

        return gettype($arg);
    }
}
