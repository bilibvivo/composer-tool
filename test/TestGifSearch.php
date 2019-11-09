<?php

use Dtool\Translate\BaiduTrans;

/**
 * Created by PhpStorm.
 * User: dume
 * Date: 19-11-2
 * Time: 下午2:53
 */
class TestGifSearch extends \PHPUnit\Framework\TestCase
{
    public function testTranslate() {
        $BaiduTrans = new BaiduTrans();
        $query = "big trump";

        $r = $BaiduTrans->translate($query, 'auto', 'zh');
        var_dump($r);
    }

    public function testGiphyCategoriesSearch() {
        $search = \Dtool\Gif\Search::getInstance("Giphy");
        $categories = $search->getCategories();
        print_r($categories);

        $this->assertEquals(count($categories), 28);
    }

    public function testGiphyTagListSearch() {
        $search = \Dtool\Gif\Search::getInstance("Giphy");
        $tagList = $search->getList();
        print_r($tagList);

        $this->assertGreaterThan(0, count($tagList));
    }
}