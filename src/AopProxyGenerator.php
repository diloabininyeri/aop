<?php

namespace Zeus\Aop;


class AopProxyGenerator
{


    public function generate($className, $file): void
    {
        $code = file_get_contents($file);
        $array = explode('\\', $className);
        $class = end($array);
        $randomName = 'AopProxy_' . $class;
        $realCode = str_replace("class $class", "class $randomName", $code);
        $code = str_replace(['<?php', '?>'], '', $realCode);
        $code = trim($code);

        eval($code);//P
        $namespace = implode('\\', array_slice($array, 0, -1));
        $originalClass = "\\$namespace\\$randomName";

        $proxyCode = "
        namespace $namespace;
        
        use \Zeus\Aop\AopProxyExecutor;
        
        class $class {
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
           
        }
        ";

        eval($proxyCode);
    }
}
