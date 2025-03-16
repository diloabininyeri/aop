<?php

namespace Zeus\Aop\Tests\Stubs;

class Response
{


    public function json(array $data): string
    {
        return json_encode($data);
    }
}
