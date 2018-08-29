<?php
/**
 * Created by PhpStorm.
 * User: mehdi
 * Date: 8/25/18
 * Time: 11:02 AM
 */
namespace Apps\Trade\vendor\digital_currency\src\digitalCurrencyAPI;


class Proxy
{
    private $_Instance_Config, $_Instance_Params, $_Instance_Sender;

    public function  __construct()
    {
        $this->_Instance_Config = new Config();
        $this->_Instance_Params = new Params();
        $this->_Instance_Sender = new Sender_Data();
    }

    function __call($method, $params)
    {

        if (method_exists($this->_Instance_Config, $method)) {

            call_user_func_array(array($this->_Instance_Config, $method), $params);
        }

        if (method_exists($this->_Instance_Params, $method)) {

            call_user_func_array(array($this->_Instance_Params, $method), $params);
        }

        if (method_exists($this->_Instance_Sender, $method)) {

            if($method === 'getOutput'){
                return $this->_Instance_Sender->getOutput();
            }

            $this->_Instance_Params->setMethod($method);

            $fullUrl=$this->generateFullURL();

            $this->_Instance_Sender->setting(
                $this->_Instance_Config,$this->_Instance_Params,$fullUrl
            );

            return call_user_func_array(array($this->_Instance_Sender, $method), $params);


        }
        return $this;
    }


    private function generateFullURL()
    {
        if ($this->_Instance_Params->getMethod() === 'GET') {

            if (!empty($this->_Instance_Params->getParams()['query_string'])) {
                return $this->_Instance_Config->getFullURL() . '?' .
                    $this->_Instance_Params->getParams()['query_string'];
            } else {
                return $this->_Instance_Config->getFullURL();
            }
        } elseif ($this->_Instance_Params->getMethod() === 'POST'
            || $this->_Instance_Params->getMethod() === 'PUT' ||
            $this->_Instance_Params->getMethod() === 'DELETE') {

            return $this->_Instance_Config->getFullURL();
        }
    }
}
