<?php


use Medoo\Medoo;
use PHPUnit\Framework\TestCase;

class TestMysql extends TestCase
{
    function testTables() {
        $database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'xm_crm',
            'server' => 'rm-uf6v90i3wp87nefw7.mysql.rds.aliyuncs.com',
            'username' => 'xmjy_dev',
            'password' => 'jFlXx!p*x&9N#$EE'
        ]);

        $data = $database->query("SHOW TABLE STATUS")->fetchAll(PDO::FETCH_ASSOC);
        //print_r($data);
        foreach ($data as $item) {
            echo sprintf("%s\t%s\n", $item['Name'], $item['Comment']);
        }

        $this->assertEquals(1, 1);
    }
}