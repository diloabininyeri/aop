<?php

namespace Zeus\Aop;

readonly class AopInterceptor
{

    public function __construct(private AopAutoloader $aopAutoloader)
    {
        $this->aopAutoloader->register();
    }

    public function forceReturn(string $class,string $method,mixed $returnValue):self
    {
        AopHooks::before($class,$method,static function (AopBeforeContext $beforeContext)use($returnValue){
            $beforeContext->stop($returnValue);
        });
        return $this;
    }

}
