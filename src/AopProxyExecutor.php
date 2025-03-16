<?php

namespace Zeus\Aop;

/**
 * @noinspection PhpUnused
 * @see AopProxyGenerator::generate()
 */
class AopProxyExecutor
{

    /**
     * @noinspection PhpUnused
     * @see AopProxyGenerator::generate()
     * @param object $instance
     * @param string $class
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public static function call(object $instance, string $class, string $method, array $arguments): mixed
    {
        $beforeContext = new AopBeforeContext($class, $method, $arguments);
        AopHooks::triggerBefore($beforeContext);
        if (!$beforeContext->shouldProceed()) {
            return $beforeContext->getReturnValue();
        }
        $result = $instance->$method(...$beforeContext->getArguments());
        $afterContext = new AopAfterContext($result);
        $afterContext->setBeforeContext($beforeContext);
        $afterContext->setArguments($arguments);
        AopHooks::triggerAfter($class, $method, $afterContext);
        return $afterContext->getReturnValue();
    }


    /***
     * @param string $originalClass
     * @param string $class
     * @param string $method
     * @param array $arguments
     * @return mixed
     */

    public static function callStatic(string $originalClass,string $class,string $method,array $arguments): mixed
    {
        $beforeContext = new AopBeforeContext($class, $method, $arguments);
        AopHooks::triggerBefore($beforeContext);
        if (!$beforeContext->shouldProceed()) {
            return $beforeContext->getReturnValue();
        }
        $result = $originalClass::$method(...$beforeContext->getArguments());
        $afterContext = new AopAfterContext($result);
        $afterContext->setBeforeContext($beforeContext);
        $afterContext->setArguments($arguments);
        AopHooks::triggerAfter($class, $method, $afterContext);
        return $afterContext->getReturnValue();
    }
}
