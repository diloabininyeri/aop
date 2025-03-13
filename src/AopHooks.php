<?php

namespace Zeus\Aop;

use Closure;

/**
 *
 */
class AopHooks
{
    /**
     * @var array
     */
    private static array $calls = [];

    /***
     * @param string $class
     * @param string $method
     * @param Closure $closure
     * @return void
     */
    public static function before(string $class, string $method, Closure $closure): void
    {
        static::$calls['before'][] = [
            'class' => $class,
            'method' => $method,
            'closure' => $closure,
        ];
    }

    /**
     * @param string $class
     * @param string $method
     * @param mixed $result
     * @return void
     */
    public static function after(string $class, string $method, mixed $result): void
    {
        static::$calls['after'][] = [
            'class' => $class,
            'method' => $method,
            'closure' => $result
        ];
    }

    /**
     * @param string $class
     * @param string $method
     * @param array $arguments
     * @return void
     */
    public static function triggerBefore(string $class, string $method,array $arguments=[]): void
    {
        foreach (static::$calls['before'] ?? [] as $call) {
            if ($call['class'] === $class && $call['method'] === $method) {
                $call['closure'](...$arguments);
            }
        }
    }

    /**
     * @param string $class
     * @param string $method
     * @param AopReturn $aopReturn
     * @return void
     */
    public static function triggerAfter(string $class, string $method, AopReturn $aopReturn): void
    {
        foreach (static::$calls['after'] ?? [] as $call) {
            if ($call['class'] === $class && $call['method'] === $method) {
                $call['closure']($aopReturn);
            }
        }
    }

    /**
     * @return void
     */
    public static function reset(): void
    {
        static::$calls = [];
    }
}
