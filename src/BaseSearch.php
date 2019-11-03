<?php
/**
 * Created by PhpStorm.
 * User: dume
 * Date: 19-11-2
 * Time: 下午2:37
 */

namespace Dtool;
use GuzzleHttp\Client;

class BaseSearch
{
    public $url;
    public $httpClient;
    public $jar;
    public $cookie;
    public $headers = [];

    public function __construct($proxy = '', $jar = '', $cookie = '')
    {
        $this->jar = $jar;
        $this->cookie = $cookie;
        $this->headers['cookie'] = $cookie;
        $this->httpClient = new Client([
            'proxy' => $proxy,
            'verify' => false,
            'timeout'  => 20.0,
            'cookies' => true,
        ]);
    }

}