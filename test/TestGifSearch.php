<?php
/**
 * Created by PhpStorm.
 * User: dume
 * Date: 19-11-2
 * Time: 下午2:53
 */
class TestGifSearch extends \PHPUnit\Framework\TestCase
{
    public function testGiphyCategoriesSearch() {
        $search = \Dtool\Gif\Search::getInstance("Giphy");
        $categories = $search->getCategories();
        print_r($categories);

        $this->assertEquals(count($categories), 28);
    }

    public function testGiphyTagListSearch() {
        $search = \Dtool\Gif\Search::getInstance("Giphy");
        $tagList = $search->getList([__DIR__ . '/../src/Gif/Giphy/source/tags/']);
        print_r($tagList);

        $this->assertGreaterThan(0, count($tagList));
    }
}