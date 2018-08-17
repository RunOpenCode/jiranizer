<?php

namespace AppBundle\Enum\User;

final class JiraStatus
{
    const ENABLED     = 'enabled';
    const DISABLED    = 'disabled';
    const UNREACHABLE = 'unreachable';

    private function __construct()
    {
        // noop
    }

    public static function getAll()
    {
        static $all;

        if (null === $all) {
            $all = (new \ReflectionClass(self::class))->getConstants();
        }

        return $all;
    }
}
