<?php

use Dtool\SqliteDb;
use Dtool\Ytb\ParseHtml;
use Dtool\Ytb\Search;
use PHPUnit\Framework\TestCase;

class TestYtbSearch extends TestCase
{
    public $db;
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->db = new SqliteDb("test.db");
        parent::__construct($name, $data, $dataName);
    }

    private function db($result) {
        $sql = "";
        $t = "INSERT INTO ytb(keyword, video_id, title, description, thumbnails, video_time, create_time) VALUES('%s','%s','%s','%s','%s','%s','%s');";
        foreach ($result as $item) {
            $sql .= sprintf($t, $item['keyword'], $item['video_id'], $item['title'], $item['description'], json_encode($item['thumbnails']), $item['video_time'], $item['create_time'])."\n";
        }
        echo $sql;
        $ret = $this->db->exec($sql);
        if(!$ret){
            echo $this->db->lastErrorMsg();
        } else {
            echo "data created successfully\n";
        }
    }

    /**
     * 测试ytb搜索
     */
    public function testYtbSearch() {
        $keyword = "音乐";
        $search = new Search("http://127.0.0.1:1087");
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
            //print_r($result);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $this->assertIsArray($result);
        $this->assertGreaterThan(0, count($result));
        //$this->db($result);
    }

    /**
     * 测试歌手搜索
     * @throws Exception
     */
    public function testSingerSearch() {
        $site = "Nineku";
        $search = \Dtool\Singer\Search::getInstance($site);
    }
}