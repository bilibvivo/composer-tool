<?php
namespace Dtool\Ytb;
use Dtool\BaseSearch;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Search
 * @package Dtool\Ytb
 * @property \GuzzleHttp\Client $client
 */
class Search extends BaseSearch
{
    public $url = 'https://www.youtube.com/results?search_query=%s';


    /**
     * 获取ytb搜索列表请求内容
     * @param string $keyword
     * @return ResponseInterface
     * @throws \Exception
     */
    public function getList($keyword = '') : ResponseInterface {
        try {
            $url = sprintf($this->url, urlencode($keyword));
            $r = $this->httpClient->request('GET', $url, [
                'cookies' => $this->jar,
                'headers' => $this->headers,
            ]);
        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage());
        }

        return $r;
    }
}