<?php

namespace Zeus\Aop;

class AopLogger
{
    private string $logFile;

    public function __construct($logFile = __DIR__ . '/../debugger.log')
    {
        $this->logFile = $logFile;
    }

    public function log($state, $method, $data)
    {
        $log = sprintf("[%s] %s: %s\n", $state, $method, json_encode($data));
        file_put_contents($this->logFile, $log, FILE_APPEND);
    }
}