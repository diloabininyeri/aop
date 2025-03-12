<?php

namespace Zeus\Aop;

use Composer\Autoload\ClassLoader;

class AopAutoloader
{
    private ClassLoader $autoload;
    private AopProxyGenerator $proxyGenerator;


    public function __construct()
    {
        $this->proxyGenerator = new AopProxyGenerator();
        $this->autoload = $this->getAutoloaderClass();
    }

    private function getAutoloaderClass(): ClassLoader
    {
        $composerAutoload= array_find(
            spl_autoload_functions(),
            static fn($function) => ($function[0] ?? null) instanceof ClassLoader
        );
        return $composerAutoload[0];
    }

    public function register():void
    {
        spl_autoload_register([$this, 'loadClass'], true, true);
    }

    public function loadClass($className): bool
    {
        if (!$file = $this->autoload->findFile($className)) {
            return  false;
        }

        $this->proxyGenerator->generate($className, $file);
        return true;
    }

}
