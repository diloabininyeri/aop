<?php

namespace Zeus\Aop;

class AopInterceptor
{
    private AopLogger $logger;

    public function __construct()
    {
        $this->logger = new AopLogger();
    }

    public function before($class, $method, $args):void
    {
        $this->logger->log("Before", "$class.$method", $args);
    }

    public function after($class, $method, $result):void
    {
        $this->logger->log("After", "$class.$method", $result);
    }
}