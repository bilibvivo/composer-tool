<?php
namespace Dtool\Ytb;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Search
 * @package Dtool\Ytb
 * @property \GuzzleHttp\Client $client
 */
class Search
{
    public $url = 'https://www.youtube.com/results?search_query=%s';
    public $httpClient;
    public $jar;
    public $cookie;
    public function __construct($proxy = '', $jar = '', $cookie = '')
    {
        $this->jar = $jar;
        $this->cookie = $cookie;
        $this->httpClient = new Client([
            'proxy' => $proxy,
            'verify' => false,
            'timeout'  => 5.0,
            'cookies' => true,
        ]);
    }

    /**
     * 获取ytb搜索列表请求内容
     * @return ResponseInterface
     * @throws \Exception
     */
    public function getList($keyword = '') : ResponseInterface {
        try {
            $url = sprintf($this->url, urlencode($keyword));
            $r = $this->httpClient->request('GET', $url, [
                'cookies' => $this->jar,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                    'cache-control' => 'max-age=0',
                    'cookie' => $this->cookie
                ]
            ]);
        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage());
        }

        return $r;
    }
}