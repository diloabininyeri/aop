### Aop autoloader

```php
<?php



use Zeus\Aop\AopAutoloader;
use Zeus\Aop\AopInterceptor;
use Zeus\Aop\Tests\Stubs\Http;
use Zeus\Aop\Tests\Stubs\Response;

require_once 'vendor/autoload.php';

/*
 class Http
{

    public function get(string $url): string
    {
        return $url;
    }
}
 */
$aopFaker = new AopInterceptor(new AopAutoloader());
$aopFaker
    ->forceReturn(Http::class, 'get', new Response()->json(['id' => 1]));


echo new Http()->get('www.google.com'); // {"id":1}

```
**<p style="color: green;">continues to be developed!!!</p>**

