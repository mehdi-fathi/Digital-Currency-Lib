<?php
/**
 * Created by PhpStorm.
 * User: mehdi
 * Date: 8/25/18
 * Time: 10:36 AM
 */

namespace Apps\Trade\vendor\digital_currency\src\digitalCurrencyAPI;


class Params
{
    private $_params,$_method;

    /**
     * @param mixed $params
     */
    public function setParams(array $params)
    {
        $this->_params['query_string'] = http_build_query($params);
        $this->_params['params'] = $params;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->_method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method): void
    {
        $this->_method = $method;
    }

}
