<?php

namespace Daemon\SimplifyBundle\Component\Enum;

use ReflectionClass;
use Symfony\Component\Serializer\Exception\UnsupportedException;

abstract class Enum
{

    /**
     *
     */
    final private function __construct()
    {
        throw new UnsupportedException();
    }

    /**
     *
     */
    final private function __clone()
    {
        throw new UnsupportedException();
    }

    /**
     * @return array
     */
    final public static function toArray()
    {
        return (new ReflectionClass(static::class))->getConstants();
    }

    /**
     * @param $value
     * @return bool
     */
    final public static function isValid($value)
    {
        return in_array($value, static::toArray());
    }

}