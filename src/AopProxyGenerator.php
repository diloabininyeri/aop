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

        eval($code);//P
        $namespace = implode('\\', array_slice($array, 0, -1));
        $originalClass = "\\$namespace\\$randomName";

        $proxyCode = "
        namespace $namespace;
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
              if(\$this->service === null) {return;}
                \$beforeContext=new \Zeus\Aop\AopBeforeContext(\"$className\", \$methodName, \$arguments);
                \Zeus\Aop\AopHooks::triggerBefore(\$beforeContext);
                if (!\$beforeContext->shouldProceed()) {
                    return \$beforeContext->getReturnValue();
                }
                \$result = call_user_func_array([\$this->service, \$methodName],\$beforeContext->getArguments());
                \$afterContext= new \Zeus\Aop\AopAfterContext(\$result);
                \$afterContext->setBeforeContext(\$beforeContext);
                \$afterContext->setArguments(\$arguments);
                \Zeus\Aop\AopHooks::triggerAfter(\"$className\", \$methodName,\$afterContext);
                return \$afterContext->getReturnValue();
            }
        }
        ";
        eval($proxyCode);
    }
}
