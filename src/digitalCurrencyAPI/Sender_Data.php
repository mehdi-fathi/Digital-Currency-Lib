<?php

namespace src\digitalCurrencyAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Sender_Data
{
    private $_full_url,$_output, $_ch, $_Instance_Config, $_Instance_Params;

    public function setting(
        $Instance_Config,
        $Instance_Params,
        string $fullUrl)
    {
        $this->_Instance_Params = $Instance_Params;
        $this->_Instance_Config = $Instance_Config;
        $this->_full_url = $fullUrl;

        $this->_Instance_Config->setApiSignature(
            $this->_Instance_Params->getMethod(), $this->_Instance_Params->getParams()
        );

        $this->_ch = curl_init();

        curl_reset($this->_ch);

        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $this->_Instance_Config->getApiHttpHeader());
        curl_setopt($this->_ch, CURLOPT_URL, $this->_full_url);
    }

    public function POST()
    {
        curl_setopt($this->_ch, CURLOPT_URL, $this->_full_url);
        curl_setopt($this->_ch, CURLOPT_POST, true);
        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $this->_Instance_Params->getParams()['query_string']);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        $this->setOutput(curl_exec($this->_ch));
        //Close the cURL handle.
        curl_close($this->_ch);

        return $this->getOutput();
    }
    public function PUT()
    {
        curl_setopt($this->_ch, CURLOPT_PUT, true);
        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $this->_Instance_Params->getParams()['query_string']);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        $this->setOutput(curl_exec($this->_ch));
        //Close the cURL handle.
        curl_close($this->_ch);

        return $this->getOutput();
    }
    public function DELETE()
    {
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $this->_Instance_Params->getParams()['query_string']);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        $this->setOutput(curl_exec($this->_ch));
        //Close the cURL handle.
        curl_close($this->_ch);

        return $this->getOutput();
    }

    public function GET()
    {
        curl_setopt($this->_ch, CURLOPT_URL, $this->_full_url);

        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($this->_ch, CURLOPT_FOLLOWLOCATION, true);

        $this->setOutput(curl_exec($this->_ch));

        //Close the cURL handle.
        curl_close($this->_ch);

        return $this->getOutput();
    }

    /**
     * @param mixed $output
     */
    public function setOutput($output): void
    {
        $this->_output = $output;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->_output;
    }
}
