<?php
namespace Dtool\Ytb;
use Dtool\BaseSearch;
use Dtool\Help;
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
     * @param $url
     * @param $savePath
     * @throws \Exception
     */
    public function getListVideos($url, $savePath) {
        $file = __DIR__ . '/source/' . md5($url) . '.txt';
        try {
            $this->getPlayList($url);
            $lines = @file($file);
            foreach ($lines as $k=>$line) {
                $data = json_decode($line, true);
                print_r($data);
                $saveFile = $savePath . $data['id'] . '.mp4';
                if (!file_exists($saveFile)) {
                    $cmd = "youtube-dl --proxy socks5://127.0.0.1:1080 --no-overwrites --no-playlist -f mp4 -o '{$savePath}%(id)s.%(ext)s' 'https://www.youtube.com/watch?v=" . $data['id'] . "'";
                    echo Help::echo2($k . "：" . $cmd);
                    shell_exec($cmd);
                    echo Help::echo2($k . "：{$saveFile} downloaded success, size:".filesize($saveFile));
                } else {
                    echo Help::echo2($k . "：{$saveFile} has already been downloaded");
                }
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    /**
     * @param $url
     * @return bool
     * @throws \Exception
     */
    public function getPlayList($url, $override = false) {
        try {
            $file = __DIR__ . '/source/' . md5($url) . '.txt';
            $lines = @file($file);
            if (!$lines || $override) {
                $cmd = sprintf("youtube-dl --proxy socks5://127.0.0.1:1080 -i -j --flat-playlist '%s' > %s",
                    $url, $file);
                echo Help::echo2($cmd);
                shell_exec($cmd);
                $lines = @file($file);
            }

            echo Help::echo2("dl end! count:".count($lines));
        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage());
        }

        return true;
    }

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