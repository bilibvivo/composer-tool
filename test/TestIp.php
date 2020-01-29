<?php
use Zhuzhichao\IpLocationZh\Ip;
use PHPUnit\Framework\TestCase;

class TestIp extends TestCase
{
    public function testIpList()
    {
        $file = file("files/ip.txt");
        foreach ($file as $line) {
            $line = explode('	', $line);
            $addr = Ip::find($line[0]);
            $str = sprintf("%s %s-%s-%s %d", $line[0], $addr[0], $addr[1], $addr[2], $line[1]);
            echo $str . PHP_EOL;
            file_put_contents("files/addr.txt", $str . PHP_EOL, FILE_APPEND);
        }

        $this->assertEquals(1000, count($file));
    }

    public function testIpLocation()
    {
        $this->assertEquals(['中国', '河南', '郑州', '', '410100'], Ip::find('171.12.10.156'));
        $this->assertEquals(['中国', '山东', '', '', '370000'], Ip::find('110.223.0.43'));
        $this->assertEquals(['本机地址', '本机地址', '', '', ''], Ip::find('127.0.0.1'));
        $this->assertEquals(['中国', '浙江', '杭州', '', '330100'], Ip::find('110.75.115.70'));
    }

    public function testIpLocations()
    {
        $locations = Ip::locations();
        $this->assertArrayHasKey('北京', $locations);
        $this->assertArrayHasKey('河北', $locations);
        $this->assertGreaterThan(0, count($locations['河北']['cities']));
    }
}
