
## About Laravel

Digital Currency Lib is a lib Api for work with some API digital currency as BitMex.

### Laravel Sponsors

You just run index.php or use this code on your project.

```php
require __DIR__ . '/vendor/autoload.php';

$Api = new \src\digitalCurrencyAPI\API_digitalCurrency();

$type='order';
$Api
    ->setApiUrl("api/v1/$type")
    ->setParams([])
    ->GET();
```
