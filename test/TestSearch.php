<?php

use Dtool\Ytb\ParseHtml;
use Dtool\Ytb\Search;
use PHPUnit\Framework\TestCase;

class TestSearch extends TestCase
{
    public function testYtbSearch() {
        $keyword = "音乐";
        $search = new Search("http://127.0.0.1:1080");
        try {
            $httpResult = $search->getList($keyword);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $this->assertEquals($httpResult->getStatusCode(), 200);

        $searchHtml = $httpResult->getBody()->getContents();
        file_put_contents("test.log", $searchHtml);

        try {
            $result = ParseHtml::getYtbList($searchHtml, $keyword);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $this->assertIsArray($result);
        $this->assertEquals(count($result), 22);
    }
}