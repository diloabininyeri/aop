<?php

namespace Zeus\Aop;

use Throwable;

class AopProceed
{

    private bool $isProceed = true;

    public function proceed(): bool
    {
        return $this->isProceed;
    }

    public function halt(): void
    {
        $this->isProceed = false;
    }

    public function throw(Throwable $throwable):never
    {
        throw $throwable;
    }
}
