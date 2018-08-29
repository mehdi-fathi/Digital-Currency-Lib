<?php
/**
 * Created by PhpStorm.
 * User: mehdi
 * Date: 8/29/18
 * Time: 10:47 AM
 */
require __DIR__ . '/vendor/autoload.php';


$Api = new \src\digitalCurrencyAPI\API_digitalCurrency();

$type='order';
$Api
    ->setApiUrl("api/v1/$type")
    ->setParams([])
    ->GET();
