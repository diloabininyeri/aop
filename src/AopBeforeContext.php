<?php

namespace Zeus\Aop;

use Throwable;

/**
 *
 */
class AopBeforeContext
{
    /**
     * @var string
     */
    private string $className;
    /**
     * @var string
     */
    private string $methodName;
    /**
     * @var array
     */
    private array $arguments;
    /**
     * @var bool
     */
    private bool $proceed;
    /**
     * @var mixed|null
     */
    private mixed $returnValue {
        get {
            return $this->returnValue;
        }
    }

    /**
     * @param string $className
     * @param string $methodName
     * @param array $arguments
     */
    public function __construct(string $className, string $methodName, array $arguments)
    {
        $this->className = $className;
        $this->methodName = $methodName;
        $this->arguments = $arguments;
        $this->proceed = true;
        $this->returnValue = null;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return mixed
     */
    public function getReturnValue():mixed
    {
        return $this->returnValue;
    }

    /**
     * @noinspection PhpUnused
     * @param $returnValue
     * @return void
     */
    public function stop($returnValue = null): void
    {
        $this->proceed = false;
        $this->returnValue = $returnValue;
    }

    /**
     * @noinspection PhpUnused
     * @return bool
     */
    public function shouldProceed(): bool
    {
        return $this->proceed;
    }

    /**
     * @param array $arguments
     * @return void
     */
    public function setArguments(array $arguments):void
    {
        $this->arguments = $arguments;
    }

    public function throw(Throwable $exception):void
    {
        throw $exception;
    }
}
