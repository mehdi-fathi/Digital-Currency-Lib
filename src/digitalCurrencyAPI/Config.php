<?php
/**
 * Created by PhpStorm.
 * User: mehdi
 * Date: 8/25/18
 * Time: 10:29 AM
 */

namespace Apps\Trade\vendor\digital_currency\src\digitalCurrencyAPI;

class Config
{

    private $_api_Key, $_api_Secret_key, $_api_Url;
    private $_api_signature, $_api_Host, $_api_expires;
    private $_api_http_header = [];

    public function __construct()
    {
        $constans_json = json_decode(
            file_get_contents(dirname(__DIR__) . '../../config.json'));
        $this->setApiKey($constans_json->ApiKey)
            ->setApiSecretKey($constans_json->ApiSecretKey)
            ->setApiHost($constans_json->ApiHost);
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->_api_Key;
    }

    /**
     * @return mixed
     */
    public function getApiSecretKey()
    {
        return $this->_api_Secret_key;
    }

    /**
     * @return mixed
     */
    public function getApiSignature()
    {
        return $this->_api_signature;
    }

    /**
     * @param mixed $api_Key
     */
    public function setApiKey($api_Key)
    {
        $this->_api_Key = $api_Key;
        return $this;
    }

    /**
     * @param mixed $api_Secret_key
     */
    public function setApiSecretKey($api_Secret_key)
    {
        $this->_api_Secret_key = $api_Secret_key;
        return $this;
    }

    /**
     * @param mixed $api_signature
     */
    public function setApiSignature($method, $params): void
    {
        if ($method == 'GET' && !empty($params['query_string'])) {
            $params = "?" . $params['query_string'];
        } else {

            $params = $params['query_string'];
        }
//        $path="$method/"
        $url = $this->_api_Url;

        $generatedPathToSign = $this->generatePathToSign($method, $url, $params);

//        dd($generatedPathToSign);
        $sign = hash_hmac(
            'sha256',
            $generatedPathToSign,
            $this->getApiSecretKey());

//        dd($sign);

        $this->setApiHttpHeader($sign);

        $this->_api_signature = $sign;
    }

    /**
     * @param mixed $api_Url
     */
    public function setApiUrl($api_Url): void
    {
        $this->_api_Url = $api_Url;
    }

    /**
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->_api_Url;
    }

    /**
     * @param mixed $api_Host
     */
    public function setApiHost($api_Host)
    {
        $this->_api_Host = $api_Host;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApiHost()
    {
        return $this->_api_Host;
    }

    /**
     * @param mixed $api_expires
     */
    public function setApiExpires($api_expires = ''): void
    {
        if (empty($api_expires)) {
            $api_expires = (string)number_format(round(microtime(true) * 100000), 0, '.', '');
        }

        $this->_api_expires = $api_expires;
    }

    /**
     * @return mixed
     */
    public function getApiExpires()
    {
        if (empty($this->_api_expires)) {
            $this->setApiExpires();
        }
        return $this->_api_expires;
    }


    public function getFullURL()
    {
        return $this->getApiHost() . '/' . $this->getApiUrl();
    }

    /**
     * @param mixed $api_http_header
     */
    public function setApiHttpHeader($ApiSignature): void
    {
        $this->_api_http_header = array(
            'api-signature: ' . $ApiSignature,
            'api-key: ' . $this->getApiKey(),
            'api-nonce: ' . $this->getApiExpires(),
        );
    }

    /**
     * @return mixed
     */
    public function getApiHttpHeader()
    {
        return $this->_api_http_header;
    }

    private function generatePathToSign($method, $url, $params)
    {

        $generatedPathToSign = false;

        if ($method == 'POST' || $method == 'PUT' || $method=='DELETE') {
//            dd(json_encode($params));
            $generatedPathToSign = "$method" . '/' . "$url"
                . $this->getApiExpires() . "$params";

//            dd($generatedPathToSign);
        }
        if ($method == 'GET') {

            $generatedPathToSign = "$method" . '/' . "$url"
                . "$params" . $this->getApiExpires();

        }
        return $generatedPathToSign;
    }
}
