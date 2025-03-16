<?php

namespace Zeus\Aop\Tests\Stubs;

class Http
{

    public function get(string $url): string
    {
        return $url;
    }
}
