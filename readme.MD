### Aop autoloader

```php
<?php

use Zeus\Aop\AopAfterContext;
use Zeus\Aop\AopAutoloader;
use Zeus\Aop\AopBeforeContext;
use Zeus\Aop\Tests\Stubs\Http;

require_once 'vendor/autoload.php';


$aopAutoloader = new AopAutoloader();
$aopAutoloader->register();


$aopAutoloader->before(Http::class, 'get', static function (AopBeforeContext $beforeContext) {

    /*$beforeContext->getArguments();
    $beforeContext->getClassName();
    $beforeContext->getMethodName();*/
    //$beforeContext->stop('return value');
    //$beforeContext->throw(new RuntimeException('the method is denied'));

});

$aopAutoloader->hook(Http::class, 'get', static function (AopAfterContext $afterContext) {

    //$afterContext->getReturnValue();//bar.com
    $afterContext->forceReturnValue('example');
});

/*
 * a basic http class
 Http
{


    public function get(string $url): string
    {
        return $url;
    }
}*/
$http = new Http();
echo $http->get('bar.com'); //example
```
**<p style="color: green;">continues to be developed!!!</p>**

