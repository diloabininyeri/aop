<?php

namespace Zeus\Aop;


use ParseError;

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

        try {

            eval($code);//P
        }catch (ParseError $e) {
            throw $e;//itl make a custom exception
        }

        $namespace = implode('\\', array_slice($array, 0, -1));
        $originalClass = "\\$namespace\\$randomName";

        $proxyCode = "
        namespace $namespace;
        class $class {
            private \$service;
            private \$interceptor;
            private static \$isProxy = false;

            public function __construct(...\$args) {
                if (self::\$isProxy) {
                    return;
                }
                self::\$isProxy = true;
                \$this->service = new $originalClass(...\$args); 
                \$this->interceptor = new \\Zeus\\Aop\\AopInterceptor();

                self::\$isProxy = false;
            }

            public function __call(\$methodName, \$arguments) {
              if(\$this->service === null) {return;}
                \$this->interceptor->before(\"$class\", \$methodName, \$arguments);
                \$result = call_user_func_array([\$this->service, \$methodName], \$arguments);
                \$this->interceptor->after(\"$class\", \$methodName, \$result);
                return \$result;
            }
        }
        ";

        eval($proxyCode);
    }
}
