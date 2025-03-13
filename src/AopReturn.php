<?php

namespace Zeus\Aop;

/**
 *
 */
class AopReturn
{

    /**
     * @param mixed $value
     */
    public function __construct(private mixed $value)
    {
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setValue(mixed $value):void
    {
        $this->value = $value;
    }
}
