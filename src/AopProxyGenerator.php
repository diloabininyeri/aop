<?php

namespace Zeus\Aop;


/**
 *
 */
class AopProxyGenerator
{


    /**
     * @param $className
     * @param $file
     * @return void
     */
    public function generate($className, $file): void
    {
        $originalCode = file_get_contents($file);
        $partNamespace = explode('\\', $className);
        $originalClassName = end($partNamespace);
        $proxyClassName = 'AopProxy_' . $originalClassName;
        $realCode = str_replace("class $originalClassName", "class $proxyClassName", $originalCode);
        $modifiedOriginalCode = str_replace(['<?php', '?>'], '', $realCode);
        $modifiedOriginalCode = trim($modifiedOriginalCode);

        eval($modifiedOriginalCode);
        $namespace = implode('\\', array_slice($partNamespace, 0, -1));
        $originalClass = "\\$namespace\\$proxyClassName";
        eval($this->generateProxyCode($namespace, $originalClassName, $originalClass, $className));
    }

    /**
     * @param string $namespace
     * @param false|string $originalClassName
     * @param string $originalClass
     * @param $className
     * @return string
     */
    public function generateProxyCode(string $namespace, false|string $originalClassName, string $originalClass, $className): string
    {
        return "
        namespace $namespace;
        
        use \Zeus\Aop\AopProxyExecutor;
        
        class $originalClassName {
            private \$service;
            private static \$isProxy = false;

            public function __construct(...\$args) {
                if (self::\$isProxy) {
                    return;
                }
                self::\$isProxy = true;
                \$this->service = new $originalClass(...\$args);
                self::\$isProxy = false;
            }

            public function __call(\$methodName, \$arguments) {
               return AopProxyExecutor::call(\$this->service,\"$className\", \$methodName, \$arguments);
            }
            
            public function __get(\$name) {
                return \$this->service->\$name;
            }
            
            public function __set(\$name, \$value) {
                \$this->service->\$name = \$value;
            }
            
            public function __isset(\$name) {
                return isset(\$this->service->\$name);
            }
            
            public function __unset(\$name) {
                unset(\$this->service->\$name);
            }
            
            public static function __callStatic(\$methodName, \$arguments) {
                return AopProxyExecutor::callStatic(\"$originalClass\",\"$className\",\$methodName, \$arguments);
            }
           
        }
        ";
    }
}
