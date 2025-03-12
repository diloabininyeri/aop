<?php

namespace Zeus\Aop\Tests\Stubs;

class Order
{

    private int $id=5;


    public function __construct(private Book $book)
    {
    }

    public function getId()
    {
        return $this->book->getName() . 'Order.php' . $this->id;
    }
}