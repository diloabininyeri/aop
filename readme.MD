### Aop autoloader

```php

use Zeus\Aop\AopAutoloader;
use Zeus\Aop\AopReturn;
use Zeus\Aop\Tests\Stubs\Order;

require_once 'vendor/autoload.php';


$aopAutoloader = new AopAutoloader();
$aopAutoloader->register();


$aopAutoloader->hook(Order::class, 'getId', static function (AopReturn $aopReturn) {
    // $aopReturn->getValue(); ->5
    $aopReturn->setValue(100);
});

/**
readonly class Order
{
public function __construct(private int $id)
{
}

public function getId(): int
{
return $this->id;
}
}*/
//the getId return the 5 but set it to 100
echo new Order(5)->getId(); //100

```
**<p style="color: green;">continues to be developed!!!</p>**

