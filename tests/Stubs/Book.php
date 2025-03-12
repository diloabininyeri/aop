<?php

namespace Zeus\Aop\Tests\Stubs;


class Book
{

    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name->bar();
    }
}