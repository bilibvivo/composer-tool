<?php
/**
 * Created by PhpStorm.
 * User: dume
 * Date: 19-11-2
 * Time: 下午2:27
 */

namespace Dtool\Gif\Giphy;

use Dtool\BaseSearch;
use Dtool\Gif\GifSearchInterface;
use Dtool\Help;

class GifSearchGiphy extends BaseSearch implements GifSearchInterface
{
    public $categoryLink = 'https://giphy.com/categories';

    /**
     * 抓取栏目列表链接地址
     */
    public function getCategories()
    {
        $dir = __DIR__ . '/source/';
        $files = scandir($dir);
        $categories = [];
        foreach ($files as $file) {
            if (!is_file($dir . $file)) continue;
            $html = file_get_contents($dir . $file);

            //CATEGORIES
            if (count($categories) == 0) {
                preg_match('/<div class="category-container">(.*?)<\/div>/is', $html, $match);
                preg_match_all('/href="([^"]*)">(.*?)<\/a>/i', $match[1], $match2);
                foreach ($match2[1] as $k => $item) {
                    $categories[$match2[2][$k]] = ['link'=>$item];
                }
            }

            $category = Help::cut('<h1 class="category-title">', '</h1>', $html);
            $category = str_replace('GIFs', '', $category);
            $category = trim($category);

            //Child Tags
            preg_match_all('/<a href="([^"]*)" class="tag">(.*?)<\/a>/is', $html, $match3);
            foreach ($match3[1] as $j => $url) {
                $temp = [];
                preg_match('/data-animated="(.*?)"/i', $match3[2][$j], $out);
                $temp['animated'] = $out[1];
                preg_match('/data-still="(.*?)"/i', $match3[2][$j], $out);
                $temp['still'] = $out[1];
                $temp['figcaption'] = Help::cut("<figcaption>", "</figcaption>", $match3[2][$j]);
                $temp['title'] = Help::cut("<h4 class=\"overlay-tag-name\">", "</h4>", $match3[2][$j]);
                $categories[$category]['children'][$url] = $temp;
            }

            //tag list
            $tagListHtml = Help::cut('<div class="grid_9 omega tag-list">', '<div style=', $html);
            preg_match_all('/<a href="(.*?)">(.*?)<\/a>/i', $tagListHtml, $match4);
            foreach ($match4[1] as $k => $url) {
                $categories[$category]['tags'][$url] = $match4[2][$k];
            }
        }

        return $categories;
    }

    /**
     * 抓取gifs列表地址
     * @param array $outFiles
     * @return array
     */
    public function getList($outFiles = [])
    {
        $tags = [];
        $files = $outFiles;

        if (!$files) {
            $dir = __DIR__ . '/source/tags/';
            $scanFiles = scandir($dir);
            foreach ($scanFiles as $file) {
                if (!is_file($dir . $file)) continue;
                $files[] = $dir . $file;
            }
        }

        foreach ($files as $file) {
            if (!file_exists($file) || !is_file($file)) {
                var_dump("文件不存在 $file");
                continue;
            } else {
                echo "$file \n";
            }

            $html = file_get_contents($file);
            preg_match('/saved from url=\(\d+\)(.*?)\s+-->/i', $html, $out);
            $link = trim($out[1]);
            $temp = [];
            //相关标签
            preg_match_all('/<h3 class="[^"]*">(.*?)<\/h3>/i', $html, $out2);
            $temp['related'] = $out2[1];

            //列表
            preg_match_all('/<div class="_gifWrapper_15ggs_13"[^>]*>(.*?)<\/div><\/div><\/div>/is', $html, $out3);
            foreach ($out3[1] as $item) {
                preg_match('/<a href="(.*?)"/i', $item, $out4);
                $itemLink = $out4[1];
                $temp['list'][$itemLink] = [];

                $a = explode('/', $itemLink);
                $a = end($a);
                $a = explode('-', $a);
                $id = array_pop($a);

                $temp['list'][$itemLink]['id'] = $id;
                $temp['list'][$itemLink]['title'] = implode(' ', $a);
                $title = Help::cut('<img alt="', '"', $item);
                if ($title) {
                    $temp['list'][$itemLink]['title'] = $title;
                }
                $img = Help::cut('<div class="U-isuVilGM7PfAL6nUBxZ">', '</a>', $item);
                $temp['list'][$itemLink]['img'] = Help::cut('href="', '"', $img);
                $itemTags = Help::cut('<div class="sc-jbKcbu eeWxRj">', '</div>', $html);
                preg_match_all('/<a href="([^"]*)"[^>]*>(.*?)<\/a>/i', $itemTags, $out5);
                foreach ($out5[2] as $m => $item2) {
                    $temp['list'][$itemLink]['tags'][$item2] = $out5[1][$m];
                }
            }

            $tags[$link] = $temp;
            //break;
        }

        return $tags;
    }
}