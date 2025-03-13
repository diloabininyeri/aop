<?php

namespace Zeus\Aop\Tests\Stubs;

readonly class Order
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
