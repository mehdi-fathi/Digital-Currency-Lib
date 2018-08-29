<?php
/**
 * Created by PhpStorm.
 * User: mehdi
 * Date: 8/25/18
 * Time: 11:02 AM
 */

namespace src\digitalCurrencyAPI;



class API_digitalCurrency
{
    private $_instance_Proxy;

    public function __construct()
    {
        $this->_instance_Proxy = new Proxy();
    }

    function __call($fun, $params)
    {

        return call_user_func_array(array($this->_instance_Proxy, $fun), $params);
    }

}
