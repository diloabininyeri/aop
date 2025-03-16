<?php

namespace Zeus\Aop;

use Closure;
use Composer\Autoload\ClassLoader;

/**
 *
 */
class AopAutoloader
{
    /**
     * @var AopProxyGenerator
     */
    private AopProxyGenerator $proxyGenerator;

    /**
     *
     */
    public function __construct()
    {
        $this->proxyGenerator = new AopProxyGenerator();
    }

    /**
     * @return ClassLoader
     */
    private function getAutoloaderClass(): ClassLoader
    {
        $composerAutoload = array_find(
            spl_autoload_functions(),
            static fn($function) => ($function[0] ?? null) instanceof ClassLoader
        );
        return $composerAutoload[0];
    }

    /**
     * @return void
     */
    public function register(): void
    {
        if (!in_array([$this, 'loadClass'], spl_autoload_functions(), true)) {
            spl_autoload_register([$this, 'loadClass'], true, true);
        }
    }

    /**
     * @return void
     */
    public function unregister(): void
    {
        spl_autoload_unregister([$this, 'loadClass']);
    }

    /**
     * @param $className
     * @return bool
     */
    public function loadClass($className): bool
    {
        if (!$file = $this->getAutoloaderClass()->findFile($className)) {
            return false;
        }

        if (str_starts_with($className, 'Zeus\Aop\Aop')) {
            return $this->getAutoloaderClass()->loadClass($className);
        }

        $this->proxyGenerator->generate($className, $file);
        return true;
    }


    /**
     * @param string $class
     * @param string $method
     * @param Closure $closure
     * @return $this
     */
    public function before(string $class, string $method, Closure $closure): self
    {
        AopHooks::before($class, $method, $closure);
        return $this;
    }

    /**
     * @param string $class
     * @param string $method
     * @param Closure $closure
     * @return $this
     */
    public function hook(string $class, string $method, Closure $closure): self
    {
        AopHooks::after($class, $method, $closure);
        return $this;
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        AopHooks::reset();
    }
}
