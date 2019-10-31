<?php
use Dtool\Ytb\Search;
use PHPUnit\Framework\TestCase;

class TestSearch extends TestCase
{
    public function testYtbSearch() {
        $search = new Search();
        $this->assertEquals($search->getList(), "ytb");
    }
}