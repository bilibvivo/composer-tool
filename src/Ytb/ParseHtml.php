<?php
namespace Dtool\Ytb;

use Dtool\Help;
use Exception;
use fengqi\Hanzi\Hanzi;
use RuntimeException;

class ParseHtml
{
    /**
     * 从ytb搜索结果html中提取数组
     * @param $html
     * @param $keyword
     * @return array
     * @throws Exception
     */
    public static function getYtbList($html, $keyword) : array
    {
        if (stristr($html, 'No results for')) {
            return [];
        }

        preg_match_all('/<h3 class="yt-lockup-title[^"]*">(.*?)<\/h3>/is', $html, $matches);
        preg_match_all('/<div class="yt-thumb video-thumb">(.*?)<\/div>/is', $html, $images);

        $result = [];
        $imagesResult = $images[1];
        $videoResult = $matches[1];
        if (count($imagesResult) > count($videoResult)) {
            $imagesResult = array_slice($imagesResult,count($imagesResult) - count($videoResult));
        }

        if (count($imagesResult) == count($videoResult) && count($imagesResult) > 0) {
            foreach ($videoResult as $k=>$v) {
                $item = [];
                $item['keyword'] = $keyword;
                $item['video_id'] = Help::cut('href="/watch?v=', '"', $v);
                $item['title'] = Help::cut('title="', '"', $v);
                $item['title'] = Hanzi::turn($item['title'], true);
                $item['thumbnails'] = [];

                $img = Help::cut('data-thumb="', '"', $imagesResult[$k]);
                if (!$img) {
                    $img = Help::cut('src="', '"', $imagesResult[$k]);
                }
                if (!$img) {
                    throw new Exception("img解析错误");
                    continue;
                }

                $item['create_time'] = time();
                $item['thumbnails']['default'] = [$img, 0, 0];
                $item['video_time'] = Help::cut('<span class="video-time" aria-hidden="true">', '</span>', $imagesResult[$k]);
                $result[] = $item;
            }

            return $result;

        } elseif (stristr($html, 'window["ytInitialData"]')) {
            $json = Help::cut('window["ytInitialData"]', '};', $html);
            $json = $json . '}';
            $json = json_decode(trim($json, '= '), true);
            $json = $json['contents']['twoColumnSearchResultsRenderer']['primaryContents']['sectionListRenderer']['contents'][0]['itemSectionRenderer']['contents'];
            if ($json && count($json) > 0) {
                foreach ($json as $render) {
                    if (!isset($render['videoRenderer']['videoId'])) {
                        continue;
                    }
                    $item = [];
                    $item['keyword'] = $keyword;
                    $item['video_id'] = $render['videoRenderer']['videoId'];
                    $item['title'] = @$render['videoRenderer']['title']['simpleText'];
                    if (!$item['title']) {
                        $item['title'] = $render['videoRenderer']['title']['runs'][0]['text'];
                    }
                    $item['title'] = Hanzi::turn($item['title'], true);
                    $item['description'] = @$render['videoRenderer']['descriptionSnippet']['runs'][0]['text'];
                    $item['description'] = Hanzi::turn($item['description'], true);
                    $item['thumbnails'] = [];

                    $img = $render['videoRenderer']['thumbnail']['thumbnails'];
                    $img = end($img);
                    $item['thumbnails']['default'] = [$img['url'], $img['width'], $img['height']];
                    $item['video_time'] = @$render['videoRenderer']['lengthText']['simpleText'];
                    $item['create_time'] = time();

                    $result[] = $item;
                }

                return $result;
            } else {
                throw new RuntimeException("json解析错误");
            }

        } else {
            $a = sprintf('images:%d, videos:%d', count($imagesResult), count($videoResult));
            throw new RuntimeException("html解析错误, " . $a);
        }
    }
}