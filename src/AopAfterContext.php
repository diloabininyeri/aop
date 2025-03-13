<?php

namespace Zeus\Aop;

/**
 *
 */
class AopAfterContext
{
    /**
     * @var array
     */
    private array $arguments = [];

    /**
     * @var AopBeforeContext|null
     */
    private ?AopBeforeContext $beforeContext=null;

    /***
     * @param mixed $value
     */
    public function __construct(private mixed $value)
    {
    }

    /**
     * @return mixed
     */
    public function getReturnValue(): mixed
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function forceReturnValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     * @return void
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * @return AopBeforeContext|null
     */
    public function getBeforeContext(): ?AopBeforeContext
    {
        return $this->beforeContext;
    }

    /**
     * @param AopBeforeContext $beforeContext
     * @return void
     */
    public function setBeforeContext(AopBeforeContext $beforeContext): void
    {
        $this->beforeContext = $beforeContext;
    }
}
